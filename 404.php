<?php
// Evantis Home - 404 Error Page
require_once 'includes/config.php';
require_once 'includes/functions.php';

http_response_code(404);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sayfa Bulunamadı - Evantis Home</title>
    <meta name="robots" content="noindex, nofollow">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <section class="error-page py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="error-content">
                        <div class="error-number mb-4">
                            <h1 style="font-size: 120px; font-weight: 700; color: var(--primary-color); margin: 0;">404</h1>
                        </div>
                        <div class="error-icon mb-4">
                            <i class="fas fa-search fa-5x" style="color: var(--secondary-color); opacity: 0.5;"></i>
                        </div>
                        <h2 class="mb-3">Aradığınız Sayfa Bulunamadı</h2>
                        <p class="text-muted mb-4 lead">
                            Üzgünüz, aradığınız sayfa mevcut değil veya taşınmış olabilir.
                            <br>Lütfen aşağıdaki bağlantıları kullanarak devam edin.
                        </p>

                        <div class="error-actions mb-5">
                            <a href="index.php" class="btn btn-primary btn-lg me-2 mb-2">
                                <i class="fas fa-home me-2"></i> Ana Sayfaya Dön
                            </a>
                            <a href="products.php" class="btn btn-outline-primary btn-lg mb-2">
                                <i class="fas fa-th me-2"></i> Ürünleri İncele
                            </a>
                        </div>

                        <!-- Search Box -->
                        <div class="error-search mb-5">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <form action="search.php" method="GET">
                                        <div class="input-group input-group-lg">
                                            <input type="text"
                                                   name="q"
                                                   class="form-control"
                                                   placeholder="Aradığınız ürünü bulmaya çalışalım..."
                                                   required>
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search me-2"></i> Ara
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Links -->
                        <div class="quick-links">
                            <h5 class="mb-3">Popüler Sayfalar</h5>
                            <div class="row g-3">
                                <div class="col-md-3 col-sm-6">
                                    <a href="category.php?cat=koltuk-takimi" class="quick-link-card">
                                        <i class="fas fa-couch mb-2"></i>
                                        <p class="mb-0">Koltuk Takımı</p>
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <a href="category.php?cat=yatak-odasi" class="quick-link-card">
                                        <i class="fas fa-bed mb-2"></i>
                                        <p class="mb-0">Yatak Odası</p>
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <a href="category.php?cat=yemek-odasi" class="quick-link-card">
                                        <i class="fas fa-utensils mb-2"></i>
                                        <p class="mb-0">Yemek Odası</p>
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <a href="contact.php" class="quick-link-card">
                                        <i class="fas fa-phone mb-2"></i>
                                        <p class="mb-0">İletişim</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>

    <style>
        .quick-link-card {
            display: block;
            padding: 20px;
            text-align: center;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            transition: all 0.3s;
            text-decoration: none;
            color: var(--text-color);
        }
        .quick-link-card:hover {
            border-color: var(--secondary-color);
            background: var(--light-bg);
            transform: translateY(-5px);
            box-shadow: var(--shadow);
        }
        .quick-link-card i {
            font-size: 2rem;
            color: var(--secondary-color);
        }
    </style>
</body>
</html>
