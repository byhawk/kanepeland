# 🛋️ Evantis Home - Mobilya E-Ticaret Sitesi

Modern, hızlı ve SEO uyumlu mobilya e-ticaret platformu. JSON import sistemi ve admin paneli ile kolay yönetim.

## ✨ Özellikler

### 🎯 Frontend
- ✅ Modern ve responsive tasarım
- ✅ Bootstrap 5 ile mobil uyumlu
- ✅ Ürün listesi ve detay sayfaları
- ✅ Kategori bazlı filtreleme
- ✅ Arama sistemi
- ✅ SEO uyumlu URL yapısı
- ✅ Hero slider
- ✅ Favori ürünler

### 🔧 Admin Panel
- ✅ Güvenli admin girişi
- ✅ Dashboard ve istatistikler
- ✅ Ürün yönetimi (CRUD)
- ✅ Kategori yönetimi
- ✅ **JSON Import Sistemi**
- ✅ Toplu ürün ekleme/güncelleme
- ✅ Import log takibi

### 🤖 Otomasyon
- ✅ Cronjob ile otomatik import
- ✅ Web scraper entegrasyonu
- ✅ Otomatik güncelleme
- ✅ Email bildirimleri

### 💾 Veritabanı
- ✅ MySQL/MariaDB
- ✅ Optimize edilmiş tablo yapısı
- ✅ İlişkisel veritabanı
- ✅ Full-text search ready

## 📦 Kurulum

### Gereksinimler
- PHP 7.4 veya üzeri
- MySQL 5.7 veya üzeri
- cPanel hosting (önerilir)
- mod_rewrite aktif

### Adım 1: Dosyaları Yükleyin

```bash
# cPanel File Manager veya FTP ile yükleyin
/home/username/public_html/
```

### Adım 2: Veritabanını Oluşturun

1. cPanel'de **MySQL Databases** bölümüne gidin
2. Yeni veritabanı oluşturun: `evantis_home`
3. Yeni kullanıcı oluşturun: `evantis_user`
4. Kullanıcıyı veritabanına ekleyin (tüm yetkilerle)
5. phpMyAdmin'den `database/schema.sql` dosyasını import edin

### Adım 3: Yapılandırma

`includes/config.php` dosyasını düzenleyin:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'evantis_user');
define('DB_PASS', 'your_strong_password');
define('DB_NAME', 'evantis_home');

define('SITE_URL', 'https://yourdomain.com');
define('SITE_EMAIL', 'info@yourdomain.com');
```

### Adım 4: Dizin İzinleri

```bash
chmod 755 uploads/
chmod 755 logs/
chmod 755 scraper-data/
```

### Adım 5: .htaccess Kurulumu

`/.htaccess` dosyası otomatik olarak SEO friendly URL'leri aktif eder:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^product/([0-9]+)/(.*)$ product.php?id=$1 [L,QSA]
RewriteRule ^category/(.*)$ category.php?cat=$1 [L,QSA]
RewriteRule ^search$ search.php [L,QSA]
```

## 🔐 Admin Paneli

### İlk Giriş

```
URL: https://yourdomain.com/admin/
Kullanıcı: admin
Şifre: admin123
```

⚠️ **ÖNEMLİ**: İlk girişten sonra şifrenizi mutlaka değiştirin!

### Admin Şifre Değiştirme

```php
// create_admin.php dosyası oluşturun ve çalıştırın
<?php
require_once 'includes/config.php';

$username = 'admin';
$password = 'yeni_guvenli_sifre';
$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $db->prepare("UPDATE admin_users SET password = ? WHERE username = ?");
$stmt->execute([$hashed, $username]);
echo "Şifre güncellendi!";
?>
```

## 📥 JSON Import Sistemi

### Manuel Import (Admin Panel)

1. Admin Panel'e giriş yapın
2. **JSON Import** menüsüne tıklayın
3. `products_database.json` dosyasını seçin
4. **Yükle ve İşle** butonuna tıklayın

### JSON Format

```json
[
  {
    "name": "İkon Ayda Koltuk Takımı",
    "url": "https://site.com/urun",
    "category": "Koltuk Takımı",
    "price": "49.900 ₺",
    "description": "Ürün açıklaması...",
    "main_image": "https://site.com/image1.jpg",
    "images": [
      "https://site.com/image1.jpg",
      "https://site.com/image2.jpg"
    ],
    "specifications": {
      "Malzeme": "Ahşap",
      "Renk": "Beyaz",
      "Ölçüler": "200x100cm"
    },
    "sku": "IKN-001"
  }
]
```

### Otomatik Import (Cronjob)

#### cPanel Cronjob Kurulumu

1. cPanel'de **Cron Jobs** bölümüne gidin
2. **Add New Cron Job** tıklayın
3. Ayarları yapın:

```
Minute: 0
Hour: 3
Day: *
Month: *
Weekday: *

Command: /usr/bin/php /home/username/public_html/cron/auto-import.php
```

Bu ayar her gün saat 03:00'te otomatik import yapar.

#### Log Kontrolü

```bash
tail -f logs/auto-import-2025-01-10.log
```

## 🔄 Web Scraper Entegrasyonu

### Scraper Output Konumu

Scraper'ın output dosyasını şu konuma kaydedin:

```
/scraper-data/products_database.json
```

### Manuel Çalıştırma

```bash
cd cron
php auto-import.php
```

### Workflow

```
[Web Scraper] → [products_database.json] → [Cronjob] → [Veritabanı] → [Website]
```

## 📁 Dosya Yapısı

```
evantis-home/
├── admin/                  # Admin panel
│   ├── login.php          # Admin girişi
│   ├── index.php          # Dashboard
│   ├── products.php       # Ürün yönetimi
│   ├── categories.php     # Kategori yönetimi
│   └── import-json.php    # JSON import
├── assets/                # Frontend assets
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── main.js
│   └── images/
├── includes/              # PHP includes
│   ├── config.php         # Yapılandırma
│   ├── functions.php      # Yardımcı fonksiyonlar
│   ├── header.php         # Site header
│   └── footer.php         # Site footer
├── database/              # Veritabanı
│   └── schema.sql         # Tablo yapısı
├── cron/                  # Cronjob scripts
│   └── auto-import.php    # Otomatik import
├── uploads/               # Yüklenen dosyalar
├── logs/                  # Log dosyaları
├── scraper-data/          # Scraper output
├── index.php              # Ana sayfa
├── products.php           # Ürün listesi
├── product.php            # Ürün detay
├── category.php           # Kategori sayfası
├── search.php             # Arama
└── .htaccess             # URL rewriting
```

## 🚀 Kullanım

### Ürün Ekleme (3 Yöntem)

#### 1. Admin Panel (Manuel)
```
Admin → Ürünler → Yeni Ürün Ekle
```

#### 2. JSON Import (Toplu)
```
Admin → JSON Import → Dosya Seç → Yükle
```

#### 3. Otomatik (Cronjob)
```
Scraper çalışır → JSON oluşturur → Cronjob import eder
```

### Kategori Yönetimi

```
Admin → Kategoriler → Yeni Kategori
```

- Ana kategoriler ve alt kategoriler
- Slug otomatik oluşturulur
- Kategori başına resim

### SEO Ayarları

Her ürün için:
- Meta Title
- Meta Description
- Meta Keywords
- SEO-friendly URL (slug)

## 🔧 Özelleştirme

### Site Bilgileri

`includes/config.php` dosyasını düzenleyin:

```php
define('SITE_NAME', 'Your Site Name');
define('SITE_EMAIL', 'info@yoursite.com');
define('SITE_PHONE', '0555 123 45 67');
```

### Logo Değiştirme

```
assets/images/logo.png
```

### Renk Teması

`assets/css/style.css` dosyasında:

```css
:root {
    --primary-color: #2c3e50;
    --secondary-color: #e74c3c;
}
```

### Hero Slider İçeriği

`index.php` dosyasında carousel-item bölümlerini düzenleyin.

## 📊 Veritabanı Tabloları

| Tablo | Açıklama |
|-------|----------|
| `products` | Ürünler |
| `categories` | Kategoriler |
| `product_images` | Ürün resimleri |
| `product_specifications` | Ürün özellikleri |
| `admin_users` | Admin kullanıcıları |
| `import_logs` | Import geçmişi |
| `site_settings` | Site ayarları |

## 🐛 Sorun Giderme

### "Veritabanı bağlantı hatası"

```php
// config.php dosyasını kontrol edin
define('DB_HOST', 'localhost');  // Doğru mu?
define('DB_USER', 'username');    // Doğru mu?
define('DB_PASS', 'password');    // Doğru mu?
```

### "JSON parse hatası"

- JSON dosyasının geçerli format olduğundan emin olun
- https://jsonlint.com/ adresinde kontrol edin

### "Permission denied"

```bash
chmod 755 uploads/
chmod 755 logs/
chmod 755 scraper-data/
```

### "Ürünler görünmüyor"

```sql
-- phpMyAdmin'de çalıştırın
SELECT * FROM products WHERE status = 1 LIMIT 10;
```

## 🔒 Güvenlik

### Üretim Ortamı İçin

1. **config.php'de error reporting'i kapatın:**
```php
error_reporting(0);
ini_set('display_errors', 0);
```

2. **Admin şifresini değiştirin**

3. **Database yedeği alın:**
```bash
mysqldump -u username -p evantis_home > backup.sql
```

4. **SSL sertifikası kurun** (Let's Encrypt ücretsiz)

5. **Admin klasörünü IP ile sınırlayın** (.htaccess)

## 📈 Performans

### Önbellekleme

PHP OpCache'i aktif edin (cPanel → PHP Selector)

### Resim Optimizasyonu

```bash
# ImageMagick ile
mogrify -resize 800x800 -quality 85 uploads/products/*.jpg
```

### Database Optimizasyonu

```sql
OPTIMIZE TABLE products;
OPTIMIZE TABLE categories;
```

## 📞 Destek

### Log Dosyaları

```
logs/auto-import-YYYY-MM-DD.log
logs/error.log
```

### Debug Mode

```php
// config.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## 🎉 Özellikler Özet

| Özellik | Durum |
|---------|-------|
| Responsive Tasarım | ✅ |
| Admin Panel | ✅ |
| JSON Import | ✅ |
| Otomatik Import (Cronjob) | ✅ |
| Ürün Yönetimi | ✅ |
| Kategori Sistemi | ✅ |
| Arama | ✅ |
| SEO Uyumlu | ✅ |
| Çoklu Resim | ✅ |
| Ürün Özellikleri | ✅ |

## 📝 Lisans

Bu proje özel kullanım için geliştirilmiştir.

## 🚀 Roadmap

- [ ] Sepet sistemi
- [ ] Ödeme entegrasyonu
- [ ] Müşteri kayıt/giriş
- [ ] Sipariş yönetimi
- [ ] E-posta bildirimleri
- [ ] Blog sistemi
- [ ] Çoklu dil desteği
- [ ] API

---

**Geliştirici:** Evantis Team
**Versiyon:** 1.0.0
**Son Güncelleme:** 2025-01-10
