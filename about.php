<?php
// Evantis Home - About Page
require_once 'includes/config.php';
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hakkımızda - Evantis Home</title>
    <meta name="description" content="Evantis Home olarak kaliteli mobilya ve dekorasyon ürünleri sunuyoruz. Hikayemiz ve değerlerimiz.">

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
                    <li class="breadcrumb-item active">Hakkımızda</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- About Hero -->
    <section class="about-hero py-5" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-white">
                    <h1 class="display-4 mb-4">Evantis Home</h1>
                    <p class="lead">
                        Modern yaşam alanları için özel tasarım mobilyalar ve dekorasyon ürünleri sunuyoruz.
                        Kalite, estetik ve müşteri memnuniyeti önceliğimizdir.
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="stats-grid">
                        <div class="stat-card text-center text-white">
                            <h2 class="display-4 mb-2">15+</h2>
                            <p>Yıllık Tecrübe</p>
                        </div>
                        <div class="stat-card text-center text-white">
                            <h2 class="display-4 mb-2">50K+</h2>
                            <p>Mutlu Müşteri</p>
                        </div>
                        <div class="stat-card text-center text-white">
                            <h2 class="display-4 mb-2">1000+</h2>
                            <p>Ürün Çeşidi</p>
                        </div>
                        <div class="stat-card text-center text-white">
                            <h2 class="display-4 mb-2">25+</h2>
                            <p>Showroom</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story -->
    <section class="our-story py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="assets/images/about-story.jpg" alt="Evantis Home Story" class="img-fluid rounded shadow" onerror="this.src='https://via.placeholder.com/600x400/2B3A55/FFFFFF?text=Evantis+Home'">
                </div>
                <div class="col-lg-6">
                    <h2 class="mb-4">Hikayemiz</h2>
                    <p class="text-muted">
                        Evantis Home, 2009 yılında mobilya sektöründe kalite ve tasarım odaklı bir marka yaratma
                        vizyonuyla kuruldu. Kuruluşumuzdan bu yana, her eve özel ve estetik mobilya çözümleri
                        sunma misyonuyla çalışıyoruz.
                    </p>
                    <p class="text-muted">
                        Yılların deneyimi ve sürekli gelişen teknolojimiz ile müşterilerimize en iyi hizmeti
                        sunmak için çabalıyoruz. Modern tasarım anlayışımız ve kaliteli üretim süreçlerimizle
                        sektörde öncü markalardan biri olmayı başardık.
                    </p>
                    <p class="text-muted">
                        Bugün, Türkiye'nin dört bir yanındaki showroom'larımız ve online platformumuz ile
                        binlerce müşterimize ulaşmanın gururunu yaşıyoruz.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission -->
    <section class="vision-mission py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="info-card h-100">
                        <div class="icon-box mb-3">
                            <i class="fas fa-eye fa-3x" style="color: var(--secondary-color);"></i>
                        </div>
                        <h3 class="mb-3">Vizyonumuz</h3>
                        <p class="text-muted">
                            Türkiye'nin en güvenilir ve tercih edilen mobilya markası olmak. Modern tasarım,
                            yüksek kalite ve müşteri memnuniyetinde sektör lideri olarak, global pazarda
                            tanınan bir Türk markası yaratmak.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info-card h-100">
                        <div class="icon-box mb-3">
                            <i class="fas fa-bullseye fa-3x" style="color: var(--secondary-color);"></i>
                        </div>
                        <h3 class="mb-3">Misyonumuz</h3>
                        <p class="text-muted">
                            Her eve estetik, konforlu ve kaliteli mobilya çözümleri sunmak. Müşteri odaklı
                            hizmet anlayışımız, yenilikçi tasarımlarımız ve uygun fiyat politikamızla herkesin
                            hayalindeki evi kurmasına yardımcı olmak.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values -->
    <section class="our-values py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-3">Değerlerimiz</h2>
                <p class="text-muted">Evantis Home'u özel kılan temel değerlerimiz</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="value-card text-center">
                        <div class="icon-circle mb-3">
                            <i class="fas fa-award fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Kalite</h5>
                        <p class="text-muted">En kaliteli malzemeler ve üretim süreçleri ile dayanıklı mobilyalar.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="value-card text-center">
                        <div class="icon-circle mb-3">
                            <i class="fas fa-lightbulb fa-2x"></i>
                        </div>
                        <h5 class="mb-3">İnovasyon</h5>
                        <p class="text-muted">Sürekli gelişen tasarım anlayışı ve yenilikçi çözümler.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="value-card text-center">
                        <div class="icon-circle mb-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Müşteri Odaklılık</h5>
                        <p class="text-muted">Müşteri memnuniyeti her zaman önceliğimizdir.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="value-card text-center">
                        <div class="icon-circle mb-3">
                            <i class="fas fa-leaf fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Sürdürülebilirlik</h5>
                        <p class="text-muted">Çevreye duyarlı üretim ve sürdürülebilir kaynak kullanımı.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-3">Ekibimiz</h2>
                <p class="text-muted">Evantis Home ailesinin değerli üyeleri</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="team-card text-center">
                        <div class="team-image mb-3">
                            <img src="assets/images/team-1.jpg" alt="Team Member" class="img-fluid rounded-circle" onerror="this.src='https://via.placeholder.com/200/2B3A55/FFFFFF?text=CEO'">
                        </div>
                        <h5>Ahmet Yılmaz</h5>
                        <p class="text-muted">Genel Müdür</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="team-card text-center">
                        <div class="team-image mb-3">
                            <img src="assets/images/team-2.jpg" alt="Team Member" class="img-fluid rounded-circle" onerror="this.src='https://via.placeholder.com/200/2B3A55/FFFFFF?text=Tasarım'">
                        </div>
                        <h5>Elif Demir</h5>
                        <p class="text-muted">Tasarım Direktörü</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="team-card text-center">
                        <div class="team-image mb-3">
                            <img src="assets/images/team-3.jpg" alt="Team Member" class="img-fluid rounded-circle" onerror="this.src='https://via.placeholder.com/200/2B3A55/FFFFFF?text=Üretim'">
                        </div>
                        <h5>Mehmet Kaya</h5>
                        <p class="text-muted">Üretim Müdürü</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="team-card text-center">
                        <div class="team-image mb-3">
                            <img src="assets/images/team-4.jpg" alt="Team Member" class="img-fluid rounded-circle" onerror="this.src='https://via.placeholder.com/200/2B3A55/FFFFFF?text=Pazarlama'">
                        </div>
                        <h5>Ayşe Çelik</h5>
                        <p class="text-muted">Pazarlama Müdürü</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section py-5 text-center" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
        <div class="container">
            <div class="text-white">
                <h2 class="mb-4">Hayalinizdeki Evi Birlikte Kuralım</h2>
                <p class="lead mb-4">Showroom'larımızı ziyaret edin veya online alışverişin keyfini çıkarın</p>
                <div class="cta-buttons">
                    <a href="stores.php" class="btn btn-light btn-lg me-3">
                        <i class="fas fa-map-marker-alt me-2"></i> Mağazalarımız
                    </a>
                    <a href="products.php" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i> Ürünleri İncele
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
