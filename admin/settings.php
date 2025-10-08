<?php
// Evantis Home - Admin Settings
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$message = '';

// Handle settings update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_settings'])) {
    try {
        foreach ($_POST['settings'] as $key => $value) {
            $stmt = $db->prepare("
                INSERT INTO site_settings (setting_key, setting_value)
                VALUES (?, ?)
                ON DUPLICATE KEY UPDATE setting_value = ?
            ");
            $stmt->execute([$key, $value, $value]);
        }
        $message = '<div class="alert alert-success">Ayarlar başarıyla güncellendi.</div>';
    } catch (PDOException $e) {
        $message = '<div class="alert alert-danger">Hata: ' . $e->getMessage() . '</div>';
    }
}

// Get current settings
$settings = [];
try {
    $stmt = $db->query("SELECT * FROM site_settings");
    while ($row = $stmt->fetch()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
} catch (PDOException $e) {
    // Table might not exist
}

// Default values
$defaults = [
    'site_name' => 'Evantis Home',
    'site_description' => 'Modern mobilya ve dekorasyon',
    'site_email' => 'info@evantishome.com',
    'site_phone' => '0555 123 45 67',
    'site_address' => 'Ataşehir, İstanbul, Türkiye',
    'products_per_page' => '12',
    'facebook_url' => '',
    'instagram_url' => '',
    'twitter_url' => '',
    'youtube_url' => ''
];

// Merge with defaults
$settings = array_merge($defaults, $settings);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayarlar - Admin Panel</title>

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
                <a class="nav-link" href="categories.php">
                    <i class="fas fa-folder me-2"></i> Kategoriler
                </a>
                <a class="nav-link" href="import-json.php">
                    <i class="fas fa-file-import me-2"></i> JSON İmport
                </a>
                <a class="nav-link active" href="settings.php">
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
            <h2 class="mb-4">Site Ayarları</h2>

            <?php echo $message; ?>

            <form method="POST" action="">
                <div class="row g-4">
                    <!-- General Settings -->
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="mb-0"><i class="fas fa-cog me-2"></i> Genel Ayarlar</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Site Adı</label>
                                        <input type="text" name="settings[site_name]" class="form-control"
                                               value="<?php echo htmlspecialchars($settings['site_name']); ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Site E-posta</label>
                                        <input type="email" name="settings[site_email]" class="form-control"
                                               value="<?php echo htmlspecialchars($settings['site_email']); ?>">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Site Açıklaması</label>
                                        <textarea name="settings[site_description]" class="form-control" rows="2"><?php echo htmlspecialchars($settings['site_description']); ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Telefon</label>
                                        <input type="text" name="settings[site_phone]" class="form-control"
                                               value="<?php echo htmlspecialchars($settings['site_phone']); ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Sayfa Başına Ürün</label>
                                        <input type="number" name="settings[products_per_page]" class="form-control"
                                               value="<?php echo htmlspecialchars($settings['products_per_page']); ?>">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Adres</label>
                                        <textarea name="settings[site_address]" class="form-control" rows="2"><?php echo htmlspecialchars($settings['site_address']); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Settings -->
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="mb-0"><i class="fas fa-share-alt me-2"></i> Sosyal Medya</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            <i class="fab fa-facebook me-1"></i> Facebook URL
                                        </label>
                                        <input type="url" name="settings[facebook_url]" class="form-control"
                                               value="<?php echo htmlspecialchars($settings['facebook_url']); ?>"
                                               placeholder="https://facebook.com/...">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            <i class="fab fa-instagram me-1"></i> Instagram URL
                                        </label>
                                        <input type="url" name="settings[instagram_url]" class="form-control"
                                               value="<?php echo htmlspecialchars($settings['instagram_url']); ?>"
                                               placeholder="https://instagram.com/...">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            <i class="fab fa-twitter me-1"></i> Twitter URL
                                        </label>
                                        <input type="url" name="settings[twitter_url]" class="form-control"
                                               value="<?php echo htmlspecialchars($settings['twitter_url']); ?>"
                                               placeholder="https://twitter.com/...">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            <i class="fab fa-youtube me-1"></i> YouTube URL
                                        </label>
                                        <input type="url" name="settings[youtube_url]" class="form-control"
                                               value="<?php echo htmlspecialchars($settings['youtube_url']); ?>"
                                               placeholder="https://youtube.com/...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Info -->
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Sistem Bilgileri</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <p class="mb-1 text-muted">PHP Versiyonu</p>
                                        <p class="mb-0"><strong><?php echo PHP_VERSION; ?></strong></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1 text-muted">Toplam Ürün</p>
                                        <p class="mb-0"><strong><?php echo number_format(getTotalProducts()); ?></strong></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1 text-muted">Veritabanı</p>
                                        <p class="mb-0"><strong>MySQL</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12">
                        <button type="submit" name="update_settings" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i> Ayarları Kaydet
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
