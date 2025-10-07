<?php
// Evantis Home - Helper Functions

/**
 * Get featured products
 */
function getFeaturedProducts($limit = 8) {
    global $db;
    $stmt = $db->prepare("
        SELECT * FROM products
        WHERE status = 1 AND featured = 1
        ORDER BY created_at DESC
        LIMIT :limit
    ");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Get all categories
 */
function getCategories() {
    global $db;
    $stmt = $db->query("
        SELECT c.*, COUNT(p.id) as count
        FROM categories c
        LEFT JOIN products p ON c.id = p.category_id
        WHERE c.status = 1
        GROUP BY c.id
        ORDER BY c.sort_order ASC
    ");
    return $stmt->fetchAll();
}

/**
 * Get product by ID
 */
function getProduct($id) {
    global $db;
    $stmt = $db->prepare("
        SELECT p.*, c.name as category_name, c.slug as category_slug
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.id = :id AND p.status = 1
    ");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

/**
 * Get product images
 */
function getProductImages($product_id) {
    global $db;
    $stmt = $db->prepare("
        SELECT * FROM product_images
        WHERE product_id = :product_id
        ORDER BY sort_order ASC
    ");
    $stmt->execute(['product_id' => $product_id]);
    return $stmt->fetchAll();
}

/**
 * Get product specifications
 */
function getProductSpecs($product_id) {
    global $db;
    $stmt = $db->prepare("
        SELECT * FROM product_specifications
        WHERE product_id = :product_id
        ORDER BY sort_order ASC
    ");
    $stmt->execute(['product_id' => $product_id]);
    return $stmt->fetchAll();
}

/**
 * Get products by category
 */
function getProductsByCategory($category_slug, $page = 1, $limit = PRODUCTS_PER_PAGE) {
    global $db;
    $offset = ($page - 1) * $limit;

    $stmt = $db->prepare("
        SELECT p.* FROM products p
        JOIN categories c ON p.category_id = c.id
        WHERE c.slug = :slug AND p.status = 1
        ORDER BY p.created_at DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':slug', $category_slug, PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Search products
 */
function searchProducts($query, $page = 1, $limit = PRODUCTS_PER_PAGE) {
    global $db;
    $offset = ($page - 1) * $limit;
    $search = "%{$query}%";

    $stmt = $db->prepare("
        SELECT * FROM products
        WHERE status = 1 AND (name LIKE :search OR description LIKE :search)
        ORDER BY created_at DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Format price
 */
function formatPrice($price) {
    return number_format($price, 0, ',', '.') . ' ₺';
}

/**
 * Create slug from string
 */
function createSlug($string) {
    $turkish = ['ş', 'Ş', 'ı', 'İ', 'ğ', 'Ğ', 'ü', 'Ü', 'ö', 'Ö', 'ç', 'Ç'];
    $english = ['s', 's', 'i', 'i', 'g', 'g', 'u', 'u', 'o', 'o', 'c', 'c'];
    $string = str_replace($turkish, $english, $string);
    $string = strtolower(trim($string));
    $string = preg_replace('/[^a-z0-9-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    return trim($string, '-');
}

/**
 * Sanitize input
 */
function sanitize($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

/**
 * Check if user is admin
 */
function isAdmin() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Redirect
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Flash message
 */
function setFlash($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Upload image
 */
function uploadImage($file, $folder = 'products') {
    $upload_dir = UPLOAD_PATH . $folder . '/';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $file_name = uniqid() . '.' . $file_ext;
    $file_path = $upload_dir . $file_name;

    if (!in_array($file['type'], ALLOWED_IMAGE_TYPES)) {
        return ['success' => false, 'message' => 'Geçersiz dosya tipi'];
    }

    if ($file['size'] > MAX_IMAGE_SIZE) {
        return ['success' => false, 'message' => 'Dosya boyutu çok büyük'];
    }

    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        $relative_path = '/uploads/' . $folder . '/' . $file_name;
        return ['success' => true, 'path' => $relative_path];
    }

    return ['success' => false, 'message' => 'Dosya yüklenemedi'];
}

/**
 * Get total products count
 */
function getTotalProducts($category_slug = null, $search = null) {
    global $db;

    if ($category_slug) {
        $stmt = $db->prepare("
            SELECT COUNT(*) FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE c.slug = :slug AND p.status = 1
        ");
        $stmt->execute(['slug' => $category_slug]);
    } elseif ($search) {
        $search_term = "%{$search}%";
        $stmt = $db->prepare("
            SELECT COUNT(*) FROM products
            WHERE status = 1 AND (name LIKE :search OR description LIKE :search)
        ");
        $stmt->execute(['search' => $search_term]);
    } else {
        $stmt = $db->query("SELECT COUNT(*) FROM products WHERE status = 1");
    }

    return $stmt->fetchColumn();
}

/**
 * Pagination
 */
function getPagination($total, $current_page, $per_page, $base_url) {
    $total_pages = ceil($total / $per_page);

    if ($total_pages <= 1) {
        return '';
    }

    $html = '<nav><ul class="pagination justify-content-center">';

    // Previous
    if ($current_page > 1) {
        $html .= '<li class="page-item"><a class="page-link" href="' . $base_url . '&page=' . ($current_page - 1) . '">Önceki</a></li>';
    }

    // Pages
    for ($i = 1; $i <= $total_pages; $i++) {
        $active = $i == $current_page ? 'active' : '';
        $html .= '<li class="page-item ' . $active . '"><a class="page-link" href="' . $base_url . '&page=' . $i . '">' . $i . '</a></li>';
    }

    // Next
    if ($current_page < $total_pages) {
        $html .= '<li class="page-item"><a class="page-link" href="' . $base_url . '&page=' . ($current_page + 1) . '">Sonraki</a></li>';
    }

    $html .= '</ul></nav>';

    return $html;
}
?>
