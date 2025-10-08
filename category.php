<?php
// Evantis Home - Category Page
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Get category slug from URL
$category_slug = isset($_GET['cat']) ? clean($_GET['cat']) : '';

if (empty($category_slug)) {
    header('Location: products.php');
    exit;
}

// Get category info
$stmt = $db->prepare("SELECT * FROM categories WHERE slug = :slug");
$stmt->execute([':slug' => $category_slug]);
$category = $stmt->fetch();

if (!$category) {
    header('Location: 404.php');
    exit;
}

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = PRODUCTS_PER_PAGE;
$offset = ($page - 1) * $per_page;

// Get products in this category
$stmt = $db->prepare("
    SELECT p.*, c.name as category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.category_id = :category_id AND p.status = 1
    ORDER BY p.created_at DESC
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':category_id', $category['id'], PDO::PARAM_INT);
$stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll();

// Total count
$count_stmt = $db->prepare("SELECT COUNT(*) FROM products WHERE category_id = :category_id AND status = 1");
$count_stmt->execute([':category_id' => $category['id']]);
$total_products = $count_stmt->fetchColumn();
$total_pages = ceil($total_products / $per_page);

// Get all categories for sidebar
$categories = getCategories();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($category['name']); ?> - Evantis Home</title>
    <meta name="description" content="<?php echo htmlspecialchars($category['description']); ?>">

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
                    <li class="breadcrumb-item"><a href="products.php">Ürünler</a></li>
                    <li class="breadcrumb-item active"><?php echo htmlspecialchars($category['name']); ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="category-listing py-5">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 mb-4">
                    <div class="sidebar">
                        <div class="sidebar-widget mb-4">
                            <h5 class="widget-title">Kategoriler</h5>
                            <ul class="category-list">
                                <?php foreach ($categories as $cat): ?>
                                <li class="<?php echo $cat['slug'] === $category_slug ? 'active' : ''; ?>">
                                    <a href="category.php?cat=<?php echo $cat['slug']; ?>">
                                        <i class="fas fa-angle-right"></i>
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="sidebar-widget">
                            <h5 class="widget-title">İletişim</h5>
                            <div class="contact-widget">
                                <p><i class="fas fa-phone"></i> 0555 123 45 67</p>
                                <p><i class="fas fa-envelope"></i> info@evantishome.com</p>
                                <p><i class="fas fa-clock"></i> Pzt-Cmt: 09:00 - 18:00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="col-lg-9">
                    <div class="category-header mb-4">
                        <h1><?php echo htmlspecialchars($category['name']); ?></h1>
                        <p class="text-muted"><?php echo $total_products; ?> ürün bulundu</p>
                    </div>

                    <?php if (empty($products)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Bu kategoride henüz ürün bulunmamaktadır.
                        </div>
                    <?php else: ?>
                        <div class="row g-4">
                            <?php foreach ($products as $product): ?>
                            <div class="col-md-4 col-sm-6">
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

                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                        <nav class="mt-5">
                            <ul class="pagination justify-content-center">
                                <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?cat=<?php echo $category_slug; ?>&page=<?php echo $page - 1; ?>">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="?cat=<?php echo $category_slug; ?>&page=<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                                <?php endfor; ?>

                                <?php if ($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?cat=<?php echo $category_slug; ?>&page=<?php echo $page + 1; ?>">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
