<?php
// Evantis Home - Admin Dashboard
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Get statistics
$total_products = getTotalProducts();

$stmt = $db->query("SELECT COUNT(*) FROM categories");
$total_categories = $stmt->fetchColumn();

// Recent products
$recent_products = $db->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 5")->fetchAll();

// Get import logs
$import_logs = $db->query("SELECT * FROM import_logs ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Evantis Home</title>

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
        .stat-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #fff;
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
                <a class="nav-link active" href="dashboard.php">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
                <a class="nav-link" href="products.php">
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
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Dashboard</h2>
                <div class="text-muted">
                    <i class="far fa-calendar me-1"></i> <?php echo date('d F Y'); ?>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted mb-0">Toplam Ürün</p>
                                <h3 class="mb-0"><?php echo number_format($total_products); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                <i class="fas fa-folder"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted mb-0">Kategoriler</p>
                                <h3 class="mb-0"><?php echo $total_categories; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                <i class="fas fa-images"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted mb-0">Görseller</p>
                                <h3 class="mb-0">
                                    <?php
                                    $stmt = $db->query("SELECT COUNT(*) FROM product_images");
                                    echo number_format($stmt->fetchColumn());
                                    ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted mb-0">Aktif Ürünler</p>
                                <h3 class="mb-0">
                                    <?php
                                    $stmt = $db->query("SELECT COUNT(*) FROM products WHERE status = 1");
                                    echo number_format($stmt->fetchColumn());
                                    ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Recent Products -->
                <div class="col-lg-7">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-box me-2"></i> Son Eklenen Ürünler</h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($recent_products)): ?>
                                <p class="text-muted">Henüz ürün eklenmemiş.</p>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Görsel</th>
                                                <th>Ürün Adı</th>
                                                <th>Fiyat</th>
                                                <th>Durum</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_products as $product): ?>
                                            <tr>
                                                <td>
                                                    <img src="<?php echo htmlspecialchars($product['main_image']); ?>"
                                                         alt="Product"
                                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;"
                                                         onerror="this.src='../assets/images/no-image.jpg'">
                                                </td>
                                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                                <td><?php echo number_format($product['price'], 2); ?> TL</td>
                                                <td>
                                                    <?php if ($product['status'] == 1): ?>
                                                        <span class="badge bg-success">Aktif</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Pasif</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Import Logs -->
                <div class="col-lg-5">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-history me-2"></i> İmport Geçmişi</h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($import_logs)): ?>
                                <p class="text-muted">İmport kaydı bulunamadı.</p>
                            <?php else: ?>
                                <div class="list-group list-group-flush">
                                    <?php foreach ($import_logs as $log): ?>
                                    <div class="list-group-item px-0">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <p class="mb-1"><strong><?php echo $log['products_imported']; ?></strong> ürün import edildi</p>
                                                <small class="text-muted">
                                                    <i class="far fa-clock me-1"></i>
                                                    <?php echo date('d.m.Y H:i', strtotime($log['created_at'])); ?>
                                                </small>
                                            </div>
                                            <?php if ($log['status'] === 'success'): ?>
                                                <i class="fas fa-check-circle text-success"></i>
                                            <?php else: ?>
                                                <i class="fas fa-exclamation-circle text-danger"></i>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card shadow-sm mt-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-bolt me-2"></i> Hızlı İşlemler</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="import-json.php" class="btn btn-primary">
                                    <i class="fas fa-file-import me-2"></i> JSON Import Et
                                </a>
                                <a href="products.php" class="btn btn-outline-primary">
                                    <i class="fas fa-box me-2"></i> Ürünleri Yönet
                                </a>
                                <a href="categories.php" class="btn btn-outline-primary">
                                    <i class="fas fa-folder me-2"></i> Kategorileri Yönet
                                </a>
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
