-- Evantis Home Database Schema (cPanel Version)
-- İlk önce cPanel'den veritabanı oluşturun, sonra bu dosyayı import edin

-- Admin Users Table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    full_name VARCHAR(100),
    role ENUM('admin', 'editor') DEFAULT 'editor',
    status TINYINT(1) DEFAULT 1,
    last_login DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Categories Table
CREATE TABLE IF NOT EXISTS categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    image VARCHAR(255),
    parent_id INT DEFAULT NULL,
    status TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_parent (parent_id),
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Products Table
CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL DEFAULT 0,
    old_price DECIMAL(10,2),
    discount INT DEFAULT 0,
    sku VARCHAR(50) UNIQUE,
    stock_quantity INT DEFAULT 0,
    main_image VARCHAR(255),
    featured TINYINT(1) DEFAULT 0,
    status TINYINT(1) DEFAULT 1,
    views INT DEFAULT 0,
    meta_title VARCHAR(255),
    meta_description TEXT,
    meta_keywords VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category_id),
    INDEX idx_slug (slug),
    INDEX idx_status (status),
    INDEX idx_featured (featured)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Product Images Table
CREATE TABLE IF NOT EXISTS product_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255),
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_product (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Product Specifications Table
CREATE TABLE IF NOT EXISTS product_specifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    spec_key VARCHAR(100) NOT NULL,
    spec_value TEXT NOT NULL,
    sort_order INT DEFAULT 0,
    INDEX idx_product (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Import Logs Table
CREATE TABLE IF NOT EXISTS import_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    file_name VARCHAR(255),
    total_products INT,
    imported_products INT,
    updated_products INT,
    failed_products INT,
    error_message TEXT,
    status ENUM('success', 'partial', 'failed') DEFAULT 'success',
    import_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Site Settings Table
CREATE TABLE IF NOT EXISTS site_settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type VARCHAR(50) DEFAULT 'text',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Default Admin User (password: admin123)
INSERT INTO admin_users (username, password, email, full_name, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@evantishome.com', 'Admin User', 'admin');

-- Insert Default Categories
INSERT INTO categories (name, slug, description, sort_order) VALUES
('Koltuk Takımı', 'koltuk-takimi', 'Modern ve şık koltuk takımları', 1),
('Yatak Odası', 'yatak-odasi', 'Rahat ve konforlu yatak odası takımları', 2),
('Yemek Odası', 'yemek-odasi', 'Şık yemek odası takımları', 3),
('Genç Odası', 'genc-odasi', 'Fonksiyonel genç odası takımları', 4),
('TV Ünitesi', 'tv-unitesi', 'Modern TV üniteleri', 5),
('Kanepe', 'kanepe', 'Rahat kanepeler', 6),
('Köşe Takımı', 'kose-takimi', 'Geniş köşe takımları', 7),
('Bebek Odası', 'bebek-odasi', 'Güvenli bebek odası takımları', 8);

-- Insert Default Site Settings
INSERT INTO site_settings (setting_key, setting_value, setting_type) VALUES
('site_name', 'Evantis Home', 'text'),
('site_description', 'Modern mobilya ve dekorasyon', 'text'),
('site_keywords', 'mobilya, ev dekorasyon, koltuk, yatak odası', 'text'),
('site_email', 'info@evantishome.com', 'email'),
('site_phone', '0555 123 45 67', 'text'),
('facebook_url', '#', 'url'),
('instagram_url', '#', 'url'),
('twitter_url', '#', 'url'),
('youtube_url', '#', 'url');
