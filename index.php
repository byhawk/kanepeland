<?php
// Evantis Home - Ana Sayfa
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Öne çıkan ürünleri çek
$featured_products = getFeaturedProducts(8);
$categories = getCategories();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evantis Home - Mobilya & Dekorasyon</title>
    <meta name="description" content="Evantis Home ile evinize değer katın. Modern mobilya ve dekorasyon ürünleri.">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/images/hero-1.jpg" class="d-block w-100" alt="Modern Mobilyalar">
                    <div class="carousel-caption">
                        <h1>Modern Yaşam Alanları</h1>
                        <p>Eviniz için özel tasarım mobilyalar</p>
                        <a href="products.php" class="btn btn-primary btn-lg">Ürünleri İncele</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="assets/images/hero-2.jpg" class="d-block w-100" alt="Yemek Odası">
                    <div class="carousel-caption">
                        <h1>Şık Yemek Odaları</h1>
                        <p>Ailenizle keyifli sofralar için</p>
                        <a href="category.php?cat=yemek-odasi" class="btn btn-primary btn-lg">Keşfet</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="assets/images/hero-3.jpg" class="d-block w-100" alt="Yatak Odası">
                    <div class="carousel-caption">
                        <h1>Konforlu Yatak Odaları</h1>
                        <p>Huzurlu uykular için tasarlandı</p>
                        <a href="category.php?cat=yatak-odasi" class="btn btn-primary btn-lg">İncele</a>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section py-5">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2>Kategoriler</h2>
                <p>Size özel mobilya kategorileri</p>
            </div>
            <div class="row g-4">
                <?php foreach($categories as $category): ?>
                <div class="col-md-3 col-sm-6">
                    <a href="category.php?cat=<?php echo $category['slug']; ?>" class="category-card">
                        <div class="category-image">
                            <img src="<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>">
                        </div>
                        <div class="category-info">
                            <h3><?php echo $category['name']; ?></h3>
                            <span><?php echo $category['count']; ?> Ürün</span>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="products-section py-5 bg-light">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2>Öne Çıkan Ürünler</h2>
                <p>En beğenilen mobilyalar</p>
            </div>
            <div class="row g-4">
                <?php foreach($featured_products as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-card">
                        <div class="product-image">
                            <a href="product.php?id=<?php echo $product['id']; ?>">
                                <img src="<?php echo $product['main_image']; ?>" alt="<?php echo $product['name']; ?>">
                            </a>
                            <?php if($product['discount'] > 0): ?>
                            <span class="badge-discount">-%<?php echo $product['discount']; ?></span>
                            <?php endif; ?>
                            <div class="product-actions">
                                <button class="btn-action" title="Favorilere Ekle">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="btn-action" title="Hızlı Görüntüle" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <div class="product-category"><?php echo $product['category']; ?></div>
                            <h3 class="product-title">
                                <a href="product.php?id=<?php echo $product['id']; ?>">
                                    <?php echo $product['name']; ?>
                                </a>
                            </h3>
                            <div class="product-price">
                                <?php if($product['old_price']): ?>
                                <span class="old-price"><?php echo formatPrice($product['old_price']); ?></span>
                                <?php endif; ?>
                                <span class="current-price"><?php echo formatPrice($product['price']); ?></span>
                            </div>
                            <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary btn-sm w-100">
                                Detayları Gör
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-4">
                <a href="products.php" class="btn btn-outline-primary btn-lg">Tüm Ürünleri Gör</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="feature-box text-center">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h4>Ücretsiz Kargo</h4>
                        <p>5000₺ üzeri siparişlerde</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="feature-box text-center">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Güvenli Alışveriş</h4>
                        <p>SSL sertifikalı ödeme</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="feature-box text-center">
                        <div class="feature-icon">
                            <i class="fas fa-undo"></i>
                        </div>
                        <h4>Kolay İade</h4>
                        <p>14 gün içinde iade hakkı</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="feature-box text-center">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4>7/24 Destek</h4>
                        <p>Müşteri hizmetleri</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
