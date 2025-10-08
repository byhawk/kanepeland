<?php
// Evantis Home - 403 Forbidden Error Page
require_once 'includes/config.php';
require_once 'includes/functions.php';

http_response_code(403);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erişim Engellendi - Evantis Home</title>
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
                            <h1 style="font-size: 120px; font-weight: 700; color: var(--primary-color); margin: 0;">403</h1>
                        </div>
                        <div class="error-icon mb-4">
                            <i class="fas fa-ban fa-5x" style="color: var(--secondary-color); opacity: 0.5;"></i>
                        </div>
                        <h2 class="mb-3">Erişim Engellendi</h2>
                        <p class="text-muted mb-4 lead">
                            Üzgünüz, bu sayfaya erişim yetkiniz bulunmamaktadır.
                            <br>Bu içeriği görmek için gerekli izinlere sahip değilsiniz.
                        </p>

                        <div class="error-actions mb-5">
                            <a href="index.php" class="btn btn-primary btn-lg me-2 mb-2">
                                <i class="fas fa-home me-2"></i> Ana Sayfaya Dön
                            </a>
                            <a href="contact.php" class="btn btn-outline-primary btn-lg mb-2">
                                <i class="fas fa-envelope me-2"></i> Bize Ulaşın
                            </a>
                        </div>

                        <!-- Info Box -->
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Not:</strong> Eğer bu sayfaya erişmeniz gerektiğini düşünüyorsanız,
                            lütfen <a href="contact.php" class="alert-link">bizimle iletişime geçin</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
