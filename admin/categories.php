<?php
// Evantis Home - Admin Categories Management
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$categories = getCategories();

// Get product counts for each category
foreach ($categories as &$category) {
    $stmt = $db->prepare("SELECT COUNT(*) FROM products WHERE category_id = ?");
    $stmt->execute([$category['id']]);
    $category['product_count'] = $stmt->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Yönetimi - Admin Panel</title>

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
        .category-card {
            padding: 20px;
            border-radius: 10px;
            background: #fff;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
        }
        .category-card:hover {
            border-color: var(--secondary-color);
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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
                <a class="nav-link" href="products.php">
                    <i class="fas fa-box me-2"></i> Ürünler
                </a>
                <a class="nav-link active" href="categories.php">
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
            <h2 class="mb-4">Kategori Yönetimi</h2>

            <div class="row g-4">
                <?php foreach ($categories as $category): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="category-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="mb-1"><?php echo htmlspecialchars($category['name']); ?></h5>
                                <p class="text-muted mb-0 small"><?php echo htmlspecialchars($category['slug']); ?></p>
                            </div>
                            <span class="badge bg-primary rounded-pill"><?php echo $category['product_count']; ?></span>
                        </div>
                        <?php if (!empty($category['description'])): ?>
                            <p class="text-muted mb-3"><?php echo htmlspecialchars($category['description']); ?></p>
                        <?php endif; ?>
                        <div class="d-flex gap-2">
                            <a href="../category.php?cat=<?php echo $category['slug']; ?>" target="_blank" class="btn btn-sm btn-outline-primary flex-fill">
                                <i class="fas fa-eye me-1"></i> Görüntüle
                            </a>
                            <a href="products.php?category=<?php echo $category['id']; ?>" class="btn btn-sm btn-primary flex-fill">
                                <i class="fas fa-box me-1"></i> Ürünler
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Category Stats -->
            <div class="card shadow-sm mt-5">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i> Kategori İstatistikleri</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Slug</th>
                                    <th>Ürün Sayısı</th>
                                    <th>Oran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_products_all = getTotalProducts();
                                foreach ($categories as $category):
                                    $percentage = $total_products_all > 0 ? ($category['product_count'] / $total_products_all) * 100 : 0;
                                ?>
                                <tr>
                                    <td>
                                        <strong><?php echo htmlspecialchars($category['name']); ?></strong>
                                    </td>
                                    <td>
                                        <code><?php echo htmlspecialchars($category['slug']); ?></code>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary"><?php echo $category['product_count']; ?></span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" role="progressbar"
                                                 style="width: <?php echo $percentage; ?>%"
                                                 aria-valuenow="<?php echo $percentage; ?>"
                                                 aria-valuemin="0"
                                                 aria-valuemax="100">
                                                <?php echo number_format($percentage, 1); ?>%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
