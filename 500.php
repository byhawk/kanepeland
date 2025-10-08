<?php
// Evantis Home - 500 Internal Server Error Page
http_response_code(500);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sunucu Hatası - Evantis Home</title>
    <meta name="robots" content="noindex, nofollow">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <section class="error-page py-5" style="min-height: 100vh; display: flex; align-items: center;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="error-content">
                        <div class="error-number mb-4">
                            <h1 style="font-size: 120px; font-weight: 700; color: #2B3A55; margin: 0;">500</h1>
                        </div>
                        <div class="error-icon mb-4">
                            <i class="fas fa-exclamation-triangle fa-5x" style="color: #B18A5E; opacity: 0.5;"></i>
                        </div>
                        <h2 class="mb-3">Sunucu Hatası</h2>
                        <p class="text-muted mb-4 lead">
                            Üzgünüz, bir şeyler yanlış gitti.
                            <br>Teknik bir sorun yaşıyoruz ve çalışıyoruz.
                        </p>

                        <div class="error-actions mb-5">
                            <a href="javascript:location.reload()" class="btn btn-primary btn-lg me-2 mb-2">
                                <i class="fas fa-redo me-2"></i> Sayfayı Yenile
                            </a>
                            <a href="index.php" class="btn btn-outline-primary btn-lg mb-2">
                                <i class="fas fa-home me-2"></i> Ana Sayfaya Dön
                            </a>
                        </div>

                        <!-- Info Box -->
                        <div class="alert alert-warning">
                            <i class="fas fa-tools me-2"></i>
                            <strong>Bilgi:</strong> Bu hatayı düzeltmek için çalışıyoruz.
                            Lütfen birkaç dakika sonra tekrar deneyin.
                        </div>

                        <div class="mt-4">
                            <p class="text-muted">
                                Sorun devam ederse, lütfen bizimle iletişime geçin:
                                <br>
                                <a href="mailto:info@evantishome.com">info@evantishome.com</a>
                                |
                                <a href="tel:+905551234567">0555 123 45 67</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
