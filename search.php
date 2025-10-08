<?php
// Evantis Home - Search Page
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Get search query
$search_query = isset($_GET['q']) ? clean($_GET['q']) : '';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = PRODUCTS_PER_PAGE;
$offset = ($page - 1) * $per_page;

$products = [];
$total_products = 0;
$total_pages = 0;

if (!empty($search_query)) {
    // Search in products
    $search_term = '%' . $search_query . '%';
    $stmt = $db->prepare("
        SELECT p.*, c.name as category_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.status = 1 AND (
            p.name LIKE :search1 OR
            p.description LIKE :search2 OR
            p.short_description LIKE :search3
        )
        ORDER BY p.created_at DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':search1', $search_term);
    $stmt->bindValue(':search2', $search_term);
    $stmt->bindValue(':search3', $search_term);
    $stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll();

    // Total count
    $count_stmt = $db->prepare("
        SELECT COUNT(*) FROM products
        WHERE status = 1 AND (
            name LIKE :search1 OR
            description LIKE :search2 OR
            short_description LIKE :search3
        )
    ");
    $count_stmt->bindValue(':search1', $search_term);
    $count_stmt->bindValue(':search2', $search_term);
    $count_stmt->bindValue(':search3', $search_term);
    $count_stmt->execute();
    $total_products = $count_stmt->fetchColumn();
    $total_pages = ceil($total_products / $per_page);
}

$categories = getCategories();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arama: <?php echo htmlspecialchars($search_query); ?> - Evantis Home</title>
    <meta name="description" content="<?php echo htmlspecialchars($search_query); ?> için arama sonuçları">

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
                    <li class="breadcrumb-item active">Arama Sonuçları</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="search-results py-5">
        <div class="container">
            <!-- Search Header -->
            <div class="search-header text-center mb-5">
                <h1 class="mb-3">Arama Sonuçları</h1>
                <form action="search.php" method="GET" class="search-form-large">
                    <div class="input-group input-group-lg">
                        <input type="text"
                               name="q"
                               class="form-control"
                               placeholder="Ürün ara..."
                               value="<?php echo htmlspecialchars($search_query); ?>"
                               required>
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search me-2"></i> Ara
                        </button>
                    </div>
                </form>
                <?php if (!empty($search_query)): ?>
                    <p class="text-muted mt-3">
                        <strong>"<?php echo htmlspecialchars($search_query); ?>"</strong> için
                        <strong><?php echo $total_products; ?></strong> sonuç bulundu
                    </p>
                <?php endif; ?>
            </div>

            <?php if (empty($search_query)): ?>
                <!-- Empty Search -->
                <div class="text-center py-5">
                    <i class="fas fa-search fa-5x text-muted mb-4"></i>
                    <h3>Ürün Arayın</h3>
                    <p class="text-muted">Aradığınız ürünü bulmak için yukarıdaki arama kutusunu kullanın</p>
                </div>

                <!-- Popular Categories -->
                <div class="popular-categories mt-5">
                    <h4 class="text-center mb-4">Popüler Kategoriler</h4>
                    <div class="row g-3">
                        <?php foreach ($categories as $cat): ?>
                        <div class="col-md-3 col-sm-6">
                            <a href="category.php?cat=<?php echo $cat['slug']; ?>" class="category-badge">
                                <i class="fas fa-angle-right"></i>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php elseif (empty($products)): ?>
                <!-- No Results -->
                <div class="text-center py-5">
                    <i class="fas fa-search-minus fa-5x text-muted mb-4"></i>
                    <h3>Sonuç Bulunamadı</h3>
                    <p class="text-muted">
                        <strong>"<?php echo htmlspecialchars($search_query); ?>"</strong> için sonuç bulunamadı.
                        <br>Lütfen farklı kelimeler ile tekrar deneyin.
                    </p>
                    <a href="products.php" class="btn btn-primary mt-3">
                        <i class="fas fa-th me-2"></i> Tüm Ürünleri İncele
                    </a>
                </div>

            <?php else: ?>
                <!-- Products Grid -->
                <div class="row g-4">
                    <?php foreach ($products as $product): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
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
                                <button class="btn-wishlist" title="Favorilere Ekle">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                            <div class="product-info">
                                <p class="product-category">
                                    <?php echo htmlspecialchars($product['category_name']); ?>
                                </p>
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

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <nav class="mt-5">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?q=<?php echo urlencode($search_query); ?>&page=<?php echo $page - 1; ?>">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                            <a class="page-link" href="?q=<?php echo urlencode($search_query); ?>&page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?q=<?php echo urlencode($search_query); ?>&page=<?php echo $page + 1; ?>">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
