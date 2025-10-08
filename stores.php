<?php
// Evantis Home - Stores Page
require_once 'includes/config.php';
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mağazalarımız - Evantis Home</title>
    <meta name="description" content="Evantis Home mağazalarımızı ziyaret edin. Türkiye'nin her yerinde showroom'larımız.">

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
                    <li class="breadcrumb-item active">Mağazalarımız</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Stores Hero -->
    <section class="stores-hero py-5 text-center" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
        <div class="container">
            <div class="text-white">
                <h1 class="display-4 mb-3">Mağazalarımız</h1>
                <p class="lead">Türkiye'nin dört bir yanında 25+ showroom ile hizmetinizdeyiz</p>
            </div>
        </div>
    </section>

    <!-- Stores Grid -->
    <section class="stores-grid py-5">
        <div class="container">
            <div class="row g-4">
                <!-- İstanbul - Ataşehir -->
                <div class="col-lg-4 col-md-6">
                    <div class="store-card h-100">
                        <div class="store-image">
                            <img src="assets/images/store-1.jpg" alt="Ataşehir Mağaza" class="img-fluid" onerror="this.src='https://via.placeholder.com/400x250/2B3A55/FFFFFF?text=Ata%C5%9Fehir'">
                            <span class="store-badge">Merkez Showroom</span>
                        </div>
                        <div class="store-info p-4">
                            <h4 class="mb-3">İstanbul - Ataşehir</h4>
                            <div class="store-details">
                                <p class="mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    Ataköy 7-8-9-10 Mahallesi, İstanbul
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    <a href="tel:+902165551234">0216 555 12 34</a>
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    Pazartesi - Cumartesi: 09:00 - 20:00
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    Pazar: 10:00 - 18:00
                                </p>
                            </div>
                            <div class="mt-3">
                                <a href="#" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="fas fa-directions me-1"></i> Yol Tarifi
                                </a>
                                <a href="tel:+902165551234" class="btn btn-primary btn-sm">
                                    <i class="fas fa-phone me-1"></i> Ara
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- İstanbul - Kadıköy -->
                <div class="col-lg-4 col-md-6">
                    <div class="store-card h-100">
                        <div class="store-image">
                            <img src="assets/images/store-2.jpg" alt="Kadıköy Mağaza" class="img-fluid" onerror="this.src='https://via.placeholder.com/400x250/2B3A55/FFFFFF?text=Kad%C4%B1k%C3%B6y'">
                        </div>
                        <div class="store-info p-4">
                            <h4 class="mb-3">İstanbul - Kadıköy</h4>
                            <div class="store-details">
                                <p class="mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    Caddebostan Mahallesi, Kadıköy
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    <a href="tel:+902165551235">0216 555 12 35</a>
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    Pazartesi - Cumartesi: 09:00 - 20:00
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    Pazar: 10:00 - 18:00
                                </p>
                            </div>
                            <div class="mt-3">
                                <a href="#" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="fas fa-directions me-1"></i> Yol Tarifi
                                </a>
                                <a href="tel:+902165551235" class="btn btn-primary btn-sm">
                                    <i class="fas fa-phone me-1"></i> Ara
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ankara -->
                <div class="col-lg-4 col-md-6">
                    <div class="store-card h-100">
                        <div class="store-image">
                            <img src="assets/images/store-3.jpg" alt="Ankara Mağaza" class="img-fluid" onerror="this.src='https://via.placeholder.com/400x250/2B3A55/FFFFFF?text=Ankara'">
                        </div>
                        <div class="store-info p-4">
                            <h4 class="mb-3">Ankara - Çankaya</h4>
                            <div class="store-details">
                                <p class="mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    Kızılay Mahallesi, Çankaya
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    <a href="tel:+903125551234">0312 555 12 34</a>
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    Pazartesi - Cumartesi: 09:00 - 20:00
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    Pazar: 10:00 - 18:00
                                </p>
                            </div>
                            <div class="mt-3">
                                <a href="#" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="fas fa-directions me-1"></i> Yol Tarifi
                                </a>
                                <a href="tel:+903125551234" class="btn btn-primary btn-sm">
                                    <i class="fas fa-phone me-1"></i> Ara
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- İzmir -->
                <div class="col-lg-4 col-md-6">
                    <div class="store-card h-100">
                        <div class="store-image">
                            <img src="assets/images/store-4.jpg" alt="İzmir Mağaza" class="img-fluid" onerror="this.src='https://via.placeholder.com/400x250/2B3A55/FFFFFF?text=%C4%B0zmir'">
                        </div>
                        <div class="store-info p-4">
                            <h4 class="mb-3">İzmir - Bornova</h4>
                            <div class="store-details">
                                <p class="mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    Erzene Mahallesi, Bornova
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    <a href="tel:+902325551234">0232 555 12 34</a>
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    Pazartesi - Cumartesi: 09:00 - 20:00
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    Pazar: 10:00 - 18:00
                                </p>
                            </div>
                            <div class="mt-3">
                                <a href="#" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="fas fa-directions me-1"></i> Yol Tarifi
                                </a>
                                <a href="tel:+902325551234" class="btn btn-primary btn-sm">
                                    <i class="fas fa-phone me-1"></i> Ara
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Antalya -->
                <div class="col-lg-4 col-md-6">
                    <div class="store-card h-100">
                        <div class="store-image">
                            <img src="assets/images/store-5.jpg" alt="Antalya Mağaza" class="img-fluid" onerror="this.src='https://via.placeholder.com/400x250/2B3A55/FFFFFF?text=Antalya'">
                        </div>
                        <div class="store-info p-4">
                            <h4 class="mb-3">Antalya - Lara</h4>
                            <div class="store-details">
                                <p class="mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    Fener Mahallesi, Muratpaşa
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    <a href="tel:+902425551234">0242 555 12 34</a>
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    Pazartesi - Cumartesi: 09:00 - 20:00
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    Pazar: 10:00 - 18:00
                                </p>
                            </div>
                            <div class="mt-3">
                                <a href="#" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="fas fa-directions me-1"></i> Yol Tarifi
                                </a>
                                <a href="tel:+902425551234" class="btn btn-primary btn-sm">
                                    <i class="fas fa-phone me-1"></i> Ara
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bursa -->
                <div class="col-lg-4 col-md-6">
                    <div class="store-card h-100">
                        <div class="store-image">
                            <img src="assets/images/store-6.jpg" alt="Bursa Mağaza" class="img-fluid" onerror="this.src='https://via.placeholder.com/400x250/2B3A55/FFFFFF?text=Bursa'">
                        </div>
                        <div class="store-info p-4">
                            <h4 class="mb-3">Bursa - Nilüfer</h4>
                            <div class="store-details">
                                <p class="mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    Görükle Mahallesi, Nilüfer
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    <a href="tel:+902245551234">0224 555 12 34</a>
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    Pazartesi - Cumartesi: 09:00 - 20:00
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    Pazar: 10:00 - 18:00
                                </p>
                            </div>
                            <div class="mt-3">
                                <a href="#" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="fas fa-directions me-1"></i> Yol Tarifi
                                </a>
                                <a href="tel:+902245551234" class="btn btn-primary btn-sm">
                                    <i class="fas fa-phone me-1"></i> Ara
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section class="contact-cta py-5 bg-light text-center">
        <div class="container">
            <h3 class="mb-4">Size En Yakın Mağazayı Bulun</h3>
            <p class="text-muted mb-4">Ürünlerimizi yerinde görmek ve deneyimlemek için mağazalarımızı ziyaret edin</p>
            <a href="contact.php" class="btn btn-primary btn-lg">
                <i class="fas fa-phone me-2"></i> İletişime Geçin
            </a>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
