<?php
// Evantis Home - Favorites Page
require_once 'includes/config.php';
require_once 'includes/functions.php';

// In a real application, favorites would be stored in session or database
// For demo purposes, we'll create a sample structure
$favorites = [];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorilerim - Evantis Home</title>
    <meta name="description" content="Beğendiğiniz ürünleri kaydedin ve daha sonra inceleyin.">

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
                    <li class="breadcrumb-item active">Favorilerim</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="favorites-page py-5">
        <div class="container">
            <div class="page-header mb-5">
                <h1 class="mb-3">
                    <i class="fas fa-heart text-danger me-2"></i> Favorilerim
                </h1>
                <p class="text-muted">Beğendiğiniz ürünleri buradan takip edebilirsiniz</p>
            </div>

            <?php if (empty($favorites)): ?>
                <!-- Empty State -->
                <div class="empty-favorites text-center py-5">
                    <div class="icon-box mb-4">
                        <i class="far fa-heart fa-5x text-muted"></i>
                    </div>
                    <h3 class="mb-3">Favori Listeniz Boş</h3>
                    <p class="text-muted mb-4">
                        Beğendiğiniz ürünleri favorilere ekleyerek daha sonra kolayca ulaşabilirsiniz
                    </p>
                    <a href="products.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-th me-2"></i> Ürünleri İncele
                    </a>
                </div>

                <!-- How it Works -->
                <div class="how-it-works mt-5">
                    <div class="container">
                        <h4 class="text-center mb-4">Favoriler Nasıl Çalışır?</h4>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="step-card text-center">
                                    <div class="step-number mb-3">1</div>
                                    <i class="fas fa-mouse-pointer fa-3x mb-3" style="color: var(--secondary-color);"></i>
                                    <h5 class="mb-2">Ürünü Beğen</h5>
                                    <p class="text-muted">Beğendiğiniz ürünün kalp simgesine tıklayın</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="step-card text-center">
                                    <div class="step-number mb-3">2</div>
                                    <i class="fas fa-heart fa-3x mb-3" style="color: var(--secondary-color);"></i>
                                    <h5 class="mb-2">Favorilere Ekle</h5>
                                    <p class="text-muted">Ürün otomatik olarak favori listenize eklenir</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="step-card text-center">
                                    <div class="step-number mb-3">3</div>
                                    <i class="fas fa-shopping-cart fa-3x mb-3" style="color: var(--secondary-color);"></i>
                                    <h5 class="mb-2">Satın Al</h5>
                                    <p class="text-muted">Favori ürünlerinizi istediğiniz zaman satın alın</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Suggested Products -->
                <div class="suggested-products mt-5">
                    <h4 class="text-center mb-4">Size Özel Öneriler</h4>
                    <div class="row g-4">
                        <?php
                        // Get some featured products as suggestions
                        $suggested_products = getFeaturedProducts(4);
                        foreach ($suggested_products as $product):
                        ?>
                        <div class="col-lg-3 col-md-6">
                            <div class="product-card">
                                <div class="product-image">
                                    <a href="product.php?id=<?php echo $product['id']; ?>">
                                        <img src="<?php echo htmlspecialchars($product['main_image']); ?>"
                                             alt="<?php echo htmlspecialchars($product['name']); ?>"
                                             onerror="this.src='assets/images/no-image.jpg'">
                                    </a>
                                    <?php if ($product['discount_price'] > 0): ?>
                                        <span class="badge-sale">İndirimli</span>
                                    <?php endif; ?>
                                    <button class="btn-wishlist" onclick="toggleFavorite(<?php echo $product['id']; ?>)">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                                <div class="product-info">
                                    <h5 class="product-title">
                                        <a href="product.php?id=<?php echo $product['id']; ?>">
                                            <?php echo htmlspecialchars($product['name']); ?>
                                        </a>
                                    </h5>
                                    <div class="product-price">
                                        <?php if ($product['discount_price'] > 0): ?>
                                            <span class="old-price"><?php echo number_format($product['price'], 2); ?> TL</span>
                                            <span class="new-price"><?php echo number_format($product['discount_price'], 2); ?> TL</span>
                                        <?php else: ?>
                                            <span class="price"><?php echo number_format($product['price'], 2); ?> TL</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php else: ?>
                <!-- Favorites List (when there are favorites) -->
                <div class="favorites-grid">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <p class="text-muted mb-0"><?php echo count($favorites); ?> ürün listeleniyor</p>
                        <button class="btn btn-outline-danger btn-sm" onclick="clearAllFavorites()">
                            <i class="fas fa-trash me-1"></i> Tümünü Temizle
                        </button>
                    </div>

                    <div class="row g-4">
                        <!-- Favorites products will be displayed here -->
                        <!-- This would be populated with actual favorite products from database/session -->
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        // Favorites functionality (would be implemented with actual backend)
        function toggleFavorite(productId) {
            // In production, this would make an AJAX call to add/remove from favorites
            console.log('Toggle favorite for product:', productId);

            // Show notification
            alert('Bu ürün favorilerinize eklendi!');
        }

        function clearAllFavorites() {
            if (confirm('Tüm favorileri temizlemek istediğinizden emin misiniz?')) {
                // Clear favorites logic here
                location.reload();
            }
        }
    </script>
</body>
</html>
