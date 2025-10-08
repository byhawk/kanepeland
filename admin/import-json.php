<?php
// Admin - JSON Import Page
require_once '../includes/config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

$message = '';
$message_type = '';
$import_stats = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['json_file'])) {
    $file = $_FILES['json_file'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $json_content = file_get_contents($file['tmp_name']);
        $products_data = json_decode($json_content, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($products_data)) {
            $total = count($products_data);
            $imported = 0;
            $updated = 0;
            $failed = 0;
            $errors = [];

            $db->beginTransaction();

            try {
                foreach ($products_data as $product) {
                    try {
                        // Required fields check
                        if (empty($product['name']) || empty($product['url'])) {
                            $failed++;
                            $errors[] = "Ürün adı veya URL eksik";
                            continue;
                        }

                        // Create slug from name
                        $slug = createSlug($product['name']);

                        // Extract price from string (e.g., "49.900 ₺")
                        $price = 0;
                        if (isset($product['price'])) {
                            $price = preg_replace('/[^0-9]/', '', $product['price']);
                            $price = $price / 100; // Convert to decimal
                        }

                        // Find or create category
                        $category_id = null;
                        if (isset($product['category'])) {
                            $category_slug = createSlug($product['category']);
                            $stmt = $db->prepare("SELECT id FROM categories WHERE slug = :slug");
                            $stmt->execute(['slug' => $category_slug]);
                            $category = $stmt->fetch();

                            if (!$category) {
                                // Create new category
                                $stmt = $db->prepare("INSERT INTO categories (name, slug) VALUES (:name, :slug)");
                                $stmt->execute([
                                    'name' => $product['category'],
                                    'slug' => $category_slug
                                ]);
                                $category_id = $db->lastInsertId();
                            } else {
                                $category_id = $category['id'];
                            }
                        }

                        // Check if product exists (by URL or name)
                        $stmt = $db->prepare("SELECT id FROM products WHERE slug = :slug");
                        $stmt->execute(['slug' => $slug]);
                        $existing = $stmt->fetch();

                        $main_image = $product['main_image'] ?? $product['thumbnail'] ?? '';

                        if ($existing) {
                            // Update existing product
                            $stmt = $db->prepare("
                                UPDATE products SET
                                    category_id = :category_id,
                                    name = :name,
                                    description = :description,
                                    price = :price,
                                    main_image = :main_image,
                                    updated_at = NOW()
                                WHERE id = :id
                            ");
                            $stmt->execute([
                                'id' => $existing['id'],
                                'category_id' => $category_id,
                                'name' => $product['name'],
                                'description' => $product['description'] ?? '',
                                'price' => $price,
                                'main_image' => $main_image
                            ]);
                            $product_id = $existing['id'];
                            $updated++;
                        } else {
                            // Insert new product
                            $stmt = $db->prepare("
                                INSERT INTO products (
                                    category_id, name, slug, description, price,
                                    main_image, sku, status
                                ) VALUES (
                                    :category_id, :name, :slug, :description, :price,
                                    :main_image, :sku, 1
                                )
                            ");
                            $stmt->execute([
                                'category_id' => $category_id,
                                'name' => $product['name'],
                                'slug' => $slug,
                                'description' => $product['description'] ?? '',
                                'price' => $price,
                                'main_image' => $main_image,
                                'sku' => $product['sku'] ?? null
                            ]);
                            $product_id = $db->lastInsertId();
                            $imported++;
                        }

                        // Import images
                        if (!empty($product['images']) && is_array($product['images'])) {
                            // Delete old images
                            $stmt = $db->prepare("DELETE FROM product_images WHERE product_id = :product_id");
                            $stmt->execute(['product_id' => $product_id]);

                            // Insert new images
                            $sort_order = 0;
                            foreach ($product['images'] as $image_url) {
                                $stmt = $db->prepare("
                                    INSERT INTO product_images (product_id, image_url, sort_order)
                                    VALUES (:product_id, :image_url, :sort_order)
                                ");
                                $stmt->execute([
                                    'product_id' => $product_id,
                                    'image_url' => $image_url,
                                    'sort_order' => $sort_order++
                                ]);
                            }
                        }

                        // Import specifications
                        if (!empty($product['specifications']) && is_array($product['specifications'])) {
                            // Delete old specs
                            $stmt = $db->prepare("DELETE FROM product_specifications WHERE product_id = :product_id");
                            $stmt->execute(['product_id' => $product_id]);

                            // Insert new specs
                            $sort_order = 0;
                            foreach ($product['specifications'] as $key => $value) {
                                if (is_string($value)) {
                                    $stmt = $db->prepare("
                                        INSERT INTO product_specifications (product_id, spec_key, spec_value, sort_order)
                                        VALUES (:product_id, :spec_key, :spec_value, :sort_order)
                                    ");
                                    $stmt->execute([
                                        'product_id' => $product_id,
                                        'spec_key' => $key,
                                        'spec_value' => $value,
                                        'sort_order' => $sort_order++
                                    ]);
                                }
                            }
                        }

                    } catch (Exception $e) {
                        $failed++;
                        $errors[] = $product['name'] . ': ' . $e->getMessage();
                    }
                }

                $db->commit();

                // Log import
                $stmt = $db->prepare("
                    INSERT INTO import_logs (
                        file_name, total_products, imported_products,
                        updated_products, failed_products, status
                    ) VALUES (:file_name, :total, :imported, :updated, :failed, :status)
                ");
                $stmt->execute([
                    'file_name' => $file['name'],
                    'total' => $total,
                    'imported' => $imported,
                    'updated' => $updated,
                    'failed' => $failed,
                    'status' => $failed > 0 ? 'partial' : 'success'
                ]);

                $import_stats = [
                    'total' => $total,
                    'imported' => $imported,
                    'updated' => $updated,
                    'failed' => $failed,
                    'errors' => $errors
                ];

                $message = 'JSON dosyası başarıyla işlendi!';
                $message_type = 'success';

            } catch (Exception $e) {
                $db->rollBack();
                $message = 'Hata: ' . $e->getMessage();
                $message_type = 'danger';
            }

        } else {
            $message = 'Geçersiz JSON formatı!';
            $message_type = 'danger';
        }
    } else {
        $message = 'Dosya yükleme hatası!';
        $message_type = 'danger';
    }
}

// Get recent imports
$recent_imports = $db->query("
    SELECT * FROM import_logs
    ORDER BY import_date DESC
    LIMIT 10
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JSON Import - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <div class="main-content">
        <?php include 'includes/topbar.php'; ?>

        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col">
                        <h1 class="h3 mb-0"><i class="fas fa-file-import"></i> JSON Import</h1>
                        <p class="text-muted">Ürünleri JSON dosyasından içe aktarın</p>
                    </div>
                </div>

                <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if ($import_stats): ?>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-primary"><i class="fas fa-box"></i></div>
                            <div class="stat-info">
                                <h3><?php echo $import_stats['total']; ?></h3>
                                <p>Toplam Ürün</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-success"><i class="fas fa-plus"></i></div>
                            <div class="stat-info">
                                <h3><?php echo $import_stats['imported']; ?></h3>
                                <p>Yeni Eklenen</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-warning"><i class="fas fa-edit"></i></div>
                            <div class="stat-info">
                                <h3><?php echo $import_stats['updated']; ?></h3>
                                <p>Güncellenen</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-danger"><i class="fas fa-times"></i></div>
                            <div class="stat-info">
                                <h3><?php echo $import_stats['failed']; ?></h3>
                                <p>Başarısız</p>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($import_stats['errors'])): ?>
                <div class="alert alert-warning">
                    <h5>Hatalar:</h5>
                    <ul>
                        <?php foreach (array_slice($import_stats['errors'], 0, 10) as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                <?php endif; ?>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Dosya Yükle</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label class="form-label">JSON Dosyası</label>
                                        <input type="file" class="form-control" name="json_file" accept=".json" required>
                                        <small class="form-text text-muted">
                                            products_database.json dosyasını yükleyin
                                        </small>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-upload"></i> Yükle ve İşle
                                    </button>
                                </form>

                                <hr class="my-4">

                                <h6>JSON Format Örneği:</h6>
                                <pre class="bg-light p-3 rounded"><code>[
  {
    "name": "Ürün Adı",
    "url": "https://...",
    "category": "Kategori",
    "price": "49.900 ₺",
    "description": "Ürün açıklaması",
    "main_image": "https://.../image.jpg",
    "images": ["https://.../1.jpg", "https://.../2.jpg"],
    "specifications": {
      "Malzeme": "Ahşap",
      "Renk": "Beyaz"
    }
  }
]</code></pre>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Son İşlemler</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    <?php foreach ($recent_imports as $import): ?>
                                    <div class="list-group-item px-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong><?php echo htmlspecialchars($import['file_name']); ?></strong>
                                                <br>
                                                <small class="text-muted">
                                                    <?php echo date('d.m.Y H:i', strtotime($import['import_date'])); ?>
                                                </small>
                                            </div>
                                            <span class="badge bg-<?php echo $import['status'] === 'success' ? 'success' : 'warning'; ?>">
                                                <?php echo $import['total_products']; ?> ürün
                                            </span>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
