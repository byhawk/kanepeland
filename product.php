<?php
// Evantis Home - Product Detail Page
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Get product ID
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$product_id) {
    header('Location: products.php');
    exit();
}

// Get product details
$product = getProduct($product_id);

if (!$product) {
    header('Location: products.php');
    exit();
}

// Get product images
$images = getProductImages($product_id);

// Get product specifications
$specs = getProductSpecs($product_id);

// Update view count
$stmt = $db->prepare("UPDATE products SET views = views + 1 WHERE id = :id");
$stmt->execute(['id' => $product_id]);

// Related products (same category)
$stmt = $db->prepare("
    SELECT * FROM products
    WHERE category_id = :category_id AND id != :product_id AND status = 1
    ORDER BY RAND()
    LIMIT 4
");
$stmt->execute([
    'category_id' => $product['category_id'],
    'product_id' => $product_id
]);
$related_products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Evantis Home</title>
    <meta name="description" content="<?php echo htmlspecialchars(substr($product['description'], 0, 160)); ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .product-detail-image {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .product-detail-image img {
            width: 100%;
            height: auto;
        }
        .product-thumbnails {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .product-thumbnail {
            width: 80px;
            height: 80px;
            border-radius: 5px;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
        }
        .product-thumbnail:hover,
        .product-thumbnail.active {
            border-color: var(--secondary-color);
        }
        .product-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .spec-table {
            width: 100%;
        }
        .spec-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .spec-table td {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        .spec-table td:first-child {
            font-weight: 600;
            width: 40%;
        }
    </style>
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <div class="breadcrumb-section py-3 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                    <li class="breadcrumb-item"><a href="products.php">Ürünler</a></li>
                    <li class="breadcrumb-item"><a href="category.php?cat=<?php echo $product['category_slug']; ?>"><?php echo $product['category_name']; ?></a></li>
                    <li class="breadcrumb-item active"><?php echo $product['name']; ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="product-detail py-5">
        <div class="container">
            <div class="row">
                <!-- Product Images -->
                <div class="col-lg-6 mb-4">
                    <div class="product-detail-image" id="mainImage">
                        <img src="<?php echo $product['main_image']; ?>" alt="<?php echo $product['name']; ?>" id="mainImageSrc">
                    </div>
                    <?php if(!empty($images)): ?>
                    <div class="product-thumbnails">
                        <div class="product-thumbnail active" onclick="changeImage('<?php echo $product['main_image']; ?>', this)">
                            <img src="<?php echo $product['main_image']; ?>" alt="Thumbnail">
                        </div>
                        <?php foreach($images as $img): ?>
                        <div class="product-thumbnail" onclick="changeImage('<?php echo $img['image_url']; ?>', this)">
                            <img src="<?php echo $img['image_url']; ?>" alt="Thumbnail">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Product Info -->
                <div class="col-lg-6">
                    <div class="product-detail-info">
                        <div class="text-muted mb-2">
                            <i class="fas fa-tag"></i> <?php echo $product['category_name']; ?>
                        </div>
                        <h1 class="h2 mb-3"><?php echo $product['name']; ?></h1>

                        <?php if($product['sku']): ?>
                        <div class="mb-3">
                            <small class="text-muted">Ürün Kodu: <?php echo $product['sku']; ?></small>
                        </div>
                        <?php endif; ?>

                        <div class="product-price mb-4">
                            <?php if($product['old_price'] && $product['old_price'] > $product['price']): ?>
                            <span class="old-price fs-5 me-2"><?php echo formatPrice($product['old_price']); ?></span>
                            <?php endif; ?>
                            <span class="current-price fs-2"><?php echo formatPrice($product['price']); ?></span>
                        </div>

                        <div class="product-actions mb-4">
                            <button class="btn btn-primary btn-lg me-2">
                                <i class="fas fa-phone"></i> Fiyat Bilgisi Al
                            </button>
                            <button class="btn btn-outline-secondary btn-lg">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Fiyat bilgisi ve sipariş için bizimle iletişime geçin.
                        </div>

                        <div class="product-meta">
                            <div class="d-flex gap-3">
                                <span><i class="fas fa-eye"></i> <?php echo $product['views']; ?> görüntülenme</span>
                                <span><i class="far fa-clock"></i> <?php echo date('d.m.Y', strtotime($product['created_at'])); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Description & Specs -->
            <div class="row mt-5">
                <div class="col-12">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#description">Açıklama</a>
                        </li>
                        <?php if(!empty($specs)): ?>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#specifications">Özellikler</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <div class="tab-content p-4 border border-top-0">
                        <div class="tab-pane fade show active" id="description">
                            <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                        </div>
                        <?php if(!empty($specs)): ?>
                        <div class="tab-pane fade" id="specifications">
                            <table class="spec-table">
                                <?php foreach($specs as $spec): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($spec['spec_key']); ?></td>
                                    <td><?php echo htmlspecialchars($spec['spec_value']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <?php if(!empty($related_products)): ?>
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="mb-4">Benzer Ürünler</h3>
                </div>
                <?php foreach($related_products as $rp): ?>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="product-card">
                        <div class="product-image">
                            <a href="product.php?id=<?php echo $rp['id']; ?>">
                                <img src="<?php echo $rp['main_image']; ?>" alt="<?php echo $rp['name']; ?>">
                            </a>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">
                                <a href="product.php?id=<?php echo $rp['id']; ?>">
                                    <?php echo $rp['name']; ?>
                                </a>
                            </h3>
                            <div class="product-price">
                                <span class="current-price"><?php echo formatPrice($rp['price']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        function changeImage(src, element) {
            document.getElementById('mainImageSrc').src = src;
            document.querySelectorAll('.product-thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            element.classList.add('active');
        }
    </script>
</body>
</html>
