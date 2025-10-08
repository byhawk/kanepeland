<?php
// Evantis Home - Blog Page
require_once 'includes/config.php';
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Evantis Home</title>
    <meta name="description" content="Ev dekorasyonu, mobilya trendleri ve yaşam alanları hakkında ilham veren blog yazıları.">

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
                    <li class="breadcrumb-item active">Blog</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Blog Hero -->
    <section class="blog-hero py-5 text-center" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
        <div class="container">
            <div class="text-white">
                <h1 class="display-4 mb-3">Evantis Home Blog</h1>
                <p class="lead">Ev dekorasyonu, mobilya trendleri ve yaşam alanları hakkında ilham veren içerikler</p>
            </div>
        </div>
    </section>

    <!-- Blog Posts -->
    <section class="blog-posts py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Featured Post -->
                <div class="col-lg-8">
                    <article class="blog-card featured-post">
                        <div class="blog-image">
                            <img src="assets/images/blog-featured.jpg" alt="Featured Blog" class="img-fluid" onerror="this.src='https://via.placeholder.com/800x450/2B3A55/FFFFFF?text=2024+Mobilya+Trendleri'">
                            <span class="blog-badge">Öne Çıkan</span>
                        </div>
                        <div class="blog-content p-4">
                            <div class="blog-meta mb-2">
                                <span class="me-3"><i class="far fa-calendar me-1"></i> 15 Ocak 2025</span>
                                <span class="me-3"><i class="far fa-user me-1"></i> Elif Demir</span>
                                <span><i class="far fa-folder me-1"></i> Dekorasyon</span>
                            </div>
                            <h2 class="blog-title mb-3">
                                <a href="#">2025 Mobilya Trendleri: Evinizi Yenilemenin Zamanı</a>
                            </h2>
                            <p class="text-muted mb-3">
                                2025 yılında mobilya ve dekorasyon dünyasında neler var? Doğal malzemeler, sürdürülebilir tasarım ve minimalist yaklaşımlar...
                            </p>
                            <a href="#" class="btn btn-outline-primary">
                                Devamını Oku <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </article>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Search Widget -->
                    <div class="widget mb-4">
                        <h5 class="widget-title">Blog Ara</h5>
                        <form action="" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Ara...">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Categories Widget -->
                    <div class="widget mb-4">
                        <h5 class="widget-title">Kategoriler</h5>
                        <ul class="category-list">
                            <li><a href="#"><i class="fas fa-angle-right"></i> Dekorasyon</a> <span>(12)</span></li>
                            <li><a href="#"><i class="fas fa-angle-right"></i> Mobilya Trendleri</a> <span>(8)</span></li>
                            <li><a href="#"><i class="fas fa-angle-right"></i> Renk Önerileri</a> <span>(6)</span></li>
                            <li><a href="#"><i class="fas fa-angle-right"></i> Yaşam Alanları</a> <span>(10)</span></li>
                            <li><a href="#"><i class="fas fa-angle-right"></i> Bakım İpuçları</a> <span>(5)</span></li>
                        </ul>
                    </div>

                    <!-- Popular Posts Widget -->
                    <div class="widget">
                        <h5 class="widget-title">Popüler Yazılar</h5>
                        <div class="popular-posts">
                            <div class="popular-post mb-3">
                                <img src="https://via.placeholder.com/80/2B3A55/FFFFFF?text=1" alt="Post" class="img-fluid">
                                <div class="popular-post-content">
                                    <a href="#">Küçük Salonlar İçin Dekorasyon İpuçları</a>
                                    <p class="text-muted mb-0"><small>10 Ocak 2025</small></p>
                                </div>
                            </div>
                            <div class="popular-post mb-3">
                                <img src="https://via.placeholder.com/80/2B3A55/FFFFFF?text=2" alt="Post" class="img-fluid">
                                <div class="popular-post-content">
                                    <a href="#">Modern Yatak Odası Tasarımı</a>
                                    <p class="text-muted mb-0"><small>8 Ocak 2025</small></p>
                                </div>
                            </div>
                            <div class="popular-post mb-3">
                                <img src="https://via.placeholder.com/80/2B3A55/FFFFFF?text=3" alt="Post" class="img-fluid">
                                <div class="popular-post-content">
                                    <a href="#">Renk Seçiminde Nelere Dikkat Edilmeli?</a>
                                    <p class="text-muted mb-0"><small>5 Ocak 2025</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Blog Posts Grid -->
                <div class="col-lg-8">
                    <div class="row g-4">
                        <!-- Post 1 -->
                        <div class="col-md-6">
                            <article class="blog-card">
                                <div class="blog-image">
                                    <img src="assets/images/blog-1.jpg" alt="Blog Post" class="img-fluid" onerror="this.src='https://via.placeholder.com/400x250/2B3A55/FFFFFF?text=Blog+1'">
                                </div>
                                <div class="blog-content p-3">
                                    <div class="blog-meta mb-2">
                                        <span class="me-2"><i class="far fa-calendar me-1"></i> 12 Ocak 2025</span>
                                        <span><i class="far fa-folder me-1"></i> Dekorasyon</span>
                                    </div>
                                    <h5 class="blog-title mb-2">
                                        <a href="#">Salon Dekorasyonunda Yapılmaması Gerekenler</a>
                                    </h5>
                                    <p class="text-muted mb-3" style="font-size: 0.9rem;">
                                        Salon dekore ederken dikkat edilmesi gereken hatalar ve çözüm önerileri...
                                    </p>
                                    <a href="#" class="text-primary">Devamını Oku →</a>
                                </div>
                            </article>
                        </div>

                        <!-- Post 2 -->
                        <div class="col-md-6">
                            <article class="blog-card">
                                <div class="blog-image">
                                    <img src="assets/images/blog-2.jpg" alt="Blog Post" class="img-fluid" onerror="this.src='https://via.placeholder.com/400x250/2B3A55/FFFFFF?text=Blog+2'">
                                </div>
                                <div class="blog-content p-3">
                                    <div class="blog-meta mb-2">
                                        <span class="me-2"><i class="far fa-calendar me-1"></i> 10 Ocak 2025</span>
                                        <span><i class="far fa-folder me-1"></i> Mobilya</span>
                                    </div>
                                    <h5 class="blog-title mb-2">
                                        <a href="#">Koltuk Seçiminde Nelere Dikkat Etmeli?</a>
                                    </h5>
                                    <p class="text-muted mb-3" style="font-size: 0.9rem;">
                                        Doğru koltuk seçimi için önemli ipuçları ve öneriler...
                                    </p>
                                    <a href="#" class="text-primary">Devamını Oku →</a>
                                </div>
                            </article>
                        </div>

                        <!-- Post 3 -->
                        <div class="col-md-6">
                            <article class="blog-card">
                                <div class="blog-image">
                                    <img src="assets/images/blog-3.jpg" alt="Blog Post" class="img-fluid" onerror="this.src='https://via.placeholder.com/400x250/2B3A55/FFFFFF?text=Blog+3'">
                                </div>
                                <div class="blog-content p-3">
                                    <div class="blog-meta mb-2">
                                        <span class="me-2"><i class="far fa-calendar me-1"></i> 8 Ocak 2025</span>
                                        <span><i class="far fa-folder me-1"></i> Renk</span>
                                    </div>
                                    <h5 class="blog-title mb-2">
                                        <a href="#">2025'in Renk Trendleri</a>
                                    </h5>
                                    <p class="text-muted mb-3" style="font-size: 0.9rem;">
                                        Bu yıl evlerde öne çıkacak renk paletleri ve kombinasyonlar...
                                    </p>
                                    <a href="#" class="text-primary">Devamını Oku →</a>
                                </div>
                            </article>
                        </div>

                        <!-- Post 4 -->
                        <div class="col-md-6">
                            <article class="blog-card">
                                <div class="blog-image">
                                    <img src="assets/images/blog-4.jpg" alt="Blog Post" class="img-fluid" onerror="this.src='https://via.placeholder.com/400x250/2B3A55/FFFFFF?text=Blog+4'">
                                </div>
                                <div class="blog-content p-3">
                                    <div class="blog-meta mb-2">
                                        <span class="me-2"><i class="far fa-calendar me-1"></i> 6 Ocak 2025</span>
                                        <span><i class="far fa-folder me-1"></i> Bakım</span>
                                    </div>
                                    <h5 class="blog-title mb-2">
                                        <a href="#">Mobilya Bakımı İçin Pratik İpuçları</a>
                                    </h5>
                                    <p class="text-muted mb-3" style="font-size: 0.9rem;">
                                        Mobilyalarınızı yıllarca yeni gibi tutmanın püf noktaları...
                                    </p>
                                    <a href="#" class="text-primary">Devamını Oku →</a>
                                </div>
                            </article>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <nav class="mt-5">
                        <ul class="pagination justify-content-center">
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">...</a></li>
                            <li class="page-item"><a class="page-link" href="#">10</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
