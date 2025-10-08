<?php
// Evantis Home - Contact Page
require_once 'includes/config.php';
require_once 'includes/functions.php';

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean($_POST['name'] ?? '');
    $email = clean($_POST['email'] ?? '');
    $phone = clean($_POST['phone'] ?? '');
    $subject = clean($_POST['subject'] ?? '');
    $message = clean($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        $error_message = 'Lütfen tüm zorunlu alanları doldurun.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Geçerli bir e-posta adresi girin.';
    } else {
        // Here you can add email sending logic or save to database
        // For now, we'll just show success message
        $success_message = 'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.';

        // Optional: Save to database
        try {
            $stmt = $db->prepare("
                INSERT INTO contact_messages (name, email, phone, subject, message, created_at)
                VALUES (:name, :email, :phone, :subject, :message, NOW())
            ");
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':subject' => $subject,
                ':message' => $message
            ]);
        } catch (PDOException $e) {
            // Table might not exist, that's okay
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim - Evantis Home</title>
    <meta name="description" content="Evantis Home ile iletişime geçin. Sorularınız için bize ulaşın.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <div class="breadcrumb-section py-3 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                    <li class="breadcrumb-item active">İletişim</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Contact Hero -->
    <section class="contact-hero py-5 text-center" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
        <div class="container">
            <div class="text-white">
                <h1 class="display-4 mb-3">Bize Ulaşın</h1>
                <p class="lead">Sorularınız, önerileriniz veya talepleriniz için bizimle iletişime geçebilirsiniz</p>
            </div>
        </div>
    </section>

    <!-- Contact Info Cards -->
    <section class="contact-info py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="info-card text-center h-100">
                        <div class="icon-circle mb-3">
                            <i class="fas fa-phone-alt fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Telefon</h5>
                        <p class="text-muted mb-2">Pazartesi - Cumartesi<br>09:00 - 18:00</p>
                        <a href="tel:+905551234567" class="text-primary fw-bold">0555 123 45 67</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="info-card text-center h-100">
                        <div class="icon-circle mb-3">
                            <i class="fas fa-envelope fa-2x"></i>
                        </div>
                        <h5 class="mb-3">E-posta</h5>
                        <p class="text-muted mb-2">7/24 mesaj gönderebilirsiniz<br>24 saat içinde yanıt</p>
                        <a href="mailto:info@evantishome.com" class="text-primary fw-bold">info@evantishome.com</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="info-card text-center h-100">
                        <div class="icon-circle mb-3">
                            <i class="fas fa-map-marker-alt fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Adres</h5>
                        <p class="text-muted mb-2">Merkez Showroom</p>
                        <p class="text-primary fw-bold">Ataşehir, İstanbul<br>Türkiye</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form -->
    <section class="contact-form-section py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 text-center">Mesaj Gönderin</h3>

                            <?php if ($success_message): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <?php echo $success_message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php endif; ?>

                            <?php if ($error_message): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?php echo $error_message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php endif; ?>

                            <form method="POST" action="">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Adınız Soyadınız *</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">E-posta Adresiniz *</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Telefon</label>
                                        <input type="tel" class="form-control" id="phone" name="phone">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="subject" class="form-label">Konu</label>
                                        <select class="form-select" id="subject" name="subject">
                                            <option value="Genel Bilgi">Genel Bilgi</option>
                                            <option value="Ürün Hakkında">Ürün Hakkında</option>
                                            <option value="Sipariş Takibi">Sipariş Takibi</option>
                                            <option value="Şikayet">Şikayet</option>
                                            <option value="Öneri">Öneri</option>
                                            <option value="Diğer">Diğer</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label">Mesajınız *</label>
                                        <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-lg w-100">
                                            <i class="fas fa-paper-plane me-2"></i> Gönder
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container-fluid p-0">
            <div class="map-container" style="height: 450px; background: #f0f0f0;">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d48390.30995207344!2d29.085357!3d40.989335!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14cac65ad93d6287%3A0x30b9b437c57f96f8!2sAta%C5%9Fehir%2C%20%C4%B0stanbul!5e0!3m2!1str!2str!4v1234567890"
                    width="100%"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-3">Sık Sorulan Sorular</h2>
                <p class="text-muted">Merak ettikleriniz için hızlı yanıtlar</p>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Teslimat süresi ne kadar?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Stokta bulunan ürünler 2-5 iş günü içinde teslim edilir. Özel üretim ürünlerde teslimat süresi 15-30 gün arasında değişmektedir.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Ürünlerde garanti var mı?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Tüm ürünlerimiz 2 yıl garantilidir. İmalat hatalarından kaynaklanan sorunlar garanti kapsamındadır.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Taksit imkanı var mı?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Kredi kartı ile 12 taksit imkanı sunuyoruz. Ayrıca özel kampanyalarda taksit sayısı artabilmektedir.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    İade politikanız nasıl?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Ürünü teslim aldıktan sonra 14 gün içinde iade edebilirsiniz. Ürün kullanılmamış ve orijinal ambalajında olmalıdır.
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
</body>
</html>
