<?php
// Evantis Home - All Products Page
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = PRODUCTS_PER_PAGE;
$offset = ($page - 1) * $per_page;

// Get all products
$stmt = $db->prepare("
    SELECT p.*, c.name as category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.status = 1
    ORDER BY p.created_at DESC
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll();

// Total count
$total_products = getTotalProducts();
$total_pages = ceil($total_products / $per_page);

// Get categories for sidebar
$categories = getCategories();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tüm Ürünler - Evantis Home</title>
    <meta name="description" content="Evantis Home'un tüm mobilya ürünlerini keşfedin.">

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
                    <li class="breadcrumb-item active">Tüm Ürünler</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="products-listing py-5">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Kategoriler</h5>
                        </div>
                        <div class="list-group list-group-flush">
                            <a href="products.php" class="list-group-item list-group-item-action">
                                Tüm Ürünler <span class="badge bg-primary float-end"><?php echo $total_products; ?></span>
                            </a>
                            <?php foreach($categories as $cat): ?>
                            <a href="category.php?cat=<?php echo $cat['slug']; ?>" class="list-group-item list-group-item-action">
                                <?php echo $cat['name']; ?>
                                <span class="badge bg-secondary float-end"><?php echo $cat['count']; ?></span>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Products -->
                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>Tüm Ürünler</h2>
                        <div class="text-muted">
                            <?php echo $total_products; ?> ürün bulundu
                        </div>
                    </div>

                    <?php if(empty($products)): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Henüz ürün bulunmuyor.
                    </div>
                    <?php else: ?>
                    <div class="row g-4">
                        <?php foreach($products as $product): ?>
                        <div class="col-lg-4 col-md-6">
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
                                        <a href="product.php?id=<?php echo $product['id']; ?>" class="btn-action" title="Detayları Gör">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <div class="product-category"><?php echo $product['category_name']; ?></div>
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

                    <!-- Pagination -->
                    <?php if($total_pages > 1): ?>
                    <nav class="mt-5">
                        <ul class="pagination justify-content-center">
                            <?php if($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page-1; ?>">Önceki</a>
                            </li>
                            <?php endif; ?>

                            <?php for($i=1; $i<=$total_pages; $i++): ?>
                            <li class="page-item <?php echo $i==$page ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                            <?php endfor; ?>

                            <?php if($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page+1; ?>">Sonraki</a>
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
