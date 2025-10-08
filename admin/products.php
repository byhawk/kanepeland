<?php
// Evantis Home - Admin Products Management
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$message = '';

// Handle product deletion
if (isset($_POST['delete_product'])) {
    $product_id = (int)$_POST['product_id'];

    try {
        // Delete product images
        $db->prepare("DELETE FROM product_images WHERE product_id = ?")->execute([$product_id]);

        // Delete product specifications
        $db->prepare("DELETE FROM product_specifications WHERE product_id = ?")->execute([$product_id]);

        // Delete product
        $db->prepare("DELETE FROM products WHERE id = ?")->execute([$product_id]);

        $message = '<div class="alert alert-success">Ürün başarıyla silindi.</div>';
    } catch (PDOException $e) {
        $message = '<div class="alert alert-danger">Hata: ' . $e->getMessage() . '</div>';
    }
}

// Handle status toggle
if (isset($_POST['toggle_status'])) {
    $product_id = (int)$_POST['product_id'];
    $new_status = (int)$_POST['new_status'];

    try {
        $stmt = $db->prepare("UPDATE products SET status = ? WHERE id = ?");
        $stmt->execute([$new_status, $product_id]);
        $message = '<div class="alert alert-success">Ürün durumu güncellendi.</div>';
    } catch (PDOException $e) {
        $message = '<div class="alert alert-danger">Hata: ' . $e->getMessage() . '</div>';
    }
}

// Get filters
$search = isset($_GET['search']) ? clean($_GET['search']) : '';
$category_filter = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 20;
$offset = ($page - 1) * $per_page;

// Build query
$where = [];
$params = [];

if (!empty($search)) {
    $where[] = "p.name LIKE ?";
    $params[] = "%$search%";
}

if ($category_filter > 0) {
    $where[] = "p.category_id = ?";
    $params[] = $category_filter;
}

if ($status_filter !== '') {
    $where[] = "p.status = ?";
    $params[] = (int)$status_filter;
}

$where_clause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

// Get products
$sql = "SELECT p.*, c.name as category_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        $where_clause
        ORDER BY p.created_at DESC
        LIMIT $per_page OFFSET $offset";

$stmt = $db->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

// Get total count
$count_sql = "SELECT COUNT(*) FROM products p $where_clause";
$count_stmt = $db->prepare($count_sql);
$count_stmt->execute($params);
$total_products = $count_stmt->fetchColumn();
$total_pages = ceil($total_products / $per_page);

// Get all categories for filter
$categories = getCategories();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Yönetimi - Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
        .admin-sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }
        .admin-sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            transition: all 0.3s;
        }
        .admin-sidebar .nav-link:hover, .admin-sidebar .nav-link.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--hover-gold);
        }
        .product-thumbnail {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0 admin-sidebar">
            <div class="p-3 text-white">
                <h4 class="mb-4"><i class="fas fa-user-shield me-2"></i> Admin Panel</h4>
                <p class="mb-0 small">Hoş geldiniz, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></p>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
                <a class="nav-link active" href="products.php">
                    <i class="fas fa-box me-2"></i> Ürünler
                </a>
                <a class="nav-link" href="categories.php">
                    <i class="fas fa-folder me-2"></i> Kategoriler
                </a>
                <a class="nav-link" href="import-json.php">
                    <i class="fas fa-file-import me-2"></i> JSON İmport
                </a>
                <a class="nav-link" href="settings.php">
                    <i class="fas fa-cog me-2"></i> Ayarlar
                </a>
                <hr style="border-color: rgba(255, 255, 255, 0.2);">
                <a class="nav-link" href="../index.php" target="_blank">
                    <i class="fas fa-external-link-alt me-2"></i> Siteyi Görüntüle
                </a>
                <a class="nav-link" href="logout.php">
                    <i class="fas fa-sign-out-alt me-2"></i> Çıkış Yap
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 px-4 py-3">
            <h2 class="mb-4">Ürün Yönetimi</h2>

            <?php echo $message; ?>

            <!-- Filters -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Ara</label>
                            <input type="text" name="search" class="form-control" placeholder="Ürün adı..." value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Kategori</label>
                            <select name="category" class="form-select">
                                <option value="0">Tüm Kategoriler</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>" <?php echo $category_filter == $cat['id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Durum</label>
                            <select name="status" class="form-select">
                                <option value="">Tümü</option>
                                <option value="1" <?php echo $status_filter === '1' ? 'selected' : ''; ?>>Aktif</option>
                                <option value="0" <?php echo $status_filter === '0' ? 'selected' : ''; ?>>Pasif</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-1"></i> Filtrele
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Table -->
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Ürünler (<?php echo number_format($total_products); ?>)</h5>
                    <a href="import-json.php" class="btn btn-primary btn-sm">
                        <i class="fas fa-file-import me-1"></i> JSON İmport
                    </a>
                </div>
                <div class="card-body">
                    <?php if (empty($products)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> Ürün bulunamadı.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Görsel</th>
                                        <th>Ürün Adı</th>
                                        <th>Kategori</th>
                                        <th>Fiyat</th>
                                        <th>Durum</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?php echo $product['id']; ?></td>
                                        <td>
                                            <img src="<?php echo htmlspecialchars($product['main_image']); ?>"
                                                 alt="Product"
                                                 class="product-thumbnail"
                                                 onerror="this.src='../assets/images/no-image.jpg'">
                                        </td>
                                        <td>
                                            <a href="../product.php?id=<?php echo $product['id']; ?>" target="_blank">
                                                <?php echo htmlspecialchars($product['name']); ?>
                                            </a>
                                        </td>
                                        <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                        <td>
                                            <?php if ($product['discount_price'] > 0): ?>
                                                <del class="text-muted"><?php echo number_format($product['price'], 2); ?> TL</del><br>
                                                <strong><?php echo number_format($product['discount_price'], 2); ?> TL</strong>
                                            <?php else: ?>
                                                <?php echo number_format($product['price'], 2); ?> TL
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                <input type="hidden" name="new_status" value="<?php echo $product['status'] == 1 ? 0 : 1; ?>">
                                                <button type="submit" name="toggle_status" class="btn btn-sm <?php echo $product['status'] == 1 ? 'btn-success' : 'btn-secondary'; ?>">
                                                    <?php echo $product['status'] == 1 ? 'Aktif' : 'Pasif'; ?>
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <form method="POST" style="display: inline;" onsubmit="return confirm('Bu ürünü silmek istediğinizden emin misiniz?');">
                                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                <button type="submit" name="delete_product" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                        <nav class="mt-3">
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&category=<?php echo $category_filter; ?>&status=<?php echo $status_filter; ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
