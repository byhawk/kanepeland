# 🚀 Evantis Home - Hızlı Kurulum Kılavuzu

## 📋 Kurulum Öncesi Kontrol

- [ ] cPanel erişimi var
- [ ] PHP 7.4+ kurulu
- [ ] MySQL 5.7+ veya MariaDB kurulu
- [ ] Minimum 50MB disk alanı

## ⚡ 15 Dakikada Kurulum

### 1. Dosyaları Yükleyin (3 dk)

**Seçenek A - File Manager (Kolay)**
1. cPanel → File Manager → `public_html`
2. Zip dosyasını yükleyin
3. Extract edin

**Seçenek B - FTP (Gelişmiş)**
```bash
ftp yourdomain.com
> put evantis-home.zip
> bye
```

### 2. Veritabanı Oluşturun (3 dk)

**cPanel → MySQL® Databases**

1. **Veritabanı Oluştur:**
   ```
   Database Name: evantis_home
   ```

2. **Kullanıcı Oluştur:**
   ```
   Username: evantis_user
   Password: [Generate Strong Password]
   ```
   ⚠️ Şifreyi kopyalayın, lazım olacak!

3. **Kullanıcıyı Veritabanına Ekle:**
   ```
   User: evantis_user
   Database: evantis_home
   Privileges: [ALL PRIVILEGES]
   ```

### 3. Veritabanı Tablolarını İçe Aktarın (2 dk)

**cPanel → phpMyAdmin**

1. Sol menüden `evantis_home` seç
2. Üst menüden **Import** tıkla
3. **Choose File** → `database/schema.sql` seç
4. **Go** butonu tıkla

✅ İşlem başarılı mesajı göreceksiniz

### 4. Config Dosyasını Düzenleyin (2 dk)

`includes/config.php` dosyasını düzenleyin:

```php
<?php
// Veritabanı Ayarları
define('DB_HOST', 'localhost');
define('DB_USER', 'evantis_user');          // BURAYA KULLANICI ADI
define('DB_PASS', 'YOUR_PASSWORD_HERE');    // BURAYA ŞİFRE
define('DB_NAME', 'evantis_home');

// Site Ayarları
define('SITE_URL', 'https://yourdomain.com'); // BURAYA DOMAININIZ
define('SITE_EMAIL', 'info@yourdomain.com');  // BURAYA EMAIL
?>
```

### 5. Dizin İzinleri (2 dk)

cPanel File Manager'da şu klasörleri seçip **Change Permissions:**

```
uploads/        → 755
logs/           → 755
scraper-data/   → 755
```

### 6. Test Edin (3 dk)

**Website Test:**
```
https://yourdomain.com
```

✅ Ana sayfa görünmeli

**Admin Panel Test:**
```
https://yourdomain.com/admin/
Username: admin
Password: admin123
```

✅ Admin panele giriş yapabilmeli

---

## 🎯 İlk Yapılması Gerekenler

### 1. Admin Şifresini Değiştirin (Öncelikli!)

Admin Panel → Settings → Change Password

veya

File Manager'da `change_password.php` oluşturun:

```php
<?php
require_once 'includes/config.php';

$new_password = 'YeniGuvenliSifre123!';
$hashed = password_hash($new_password, PASSWORD_DEFAULT);

$stmt = $db->prepare("UPDATE admin_users SET password = ? WHERE username = 'admin'");
$stmt->execute([$hashed]);

echo "Şifre değiştirildi! Bu dosyayı silin.";
?>
```

Tarayıcıda çalıştırın: `https://yourdomain.com/change_password.php`

⚠️ Sonra dosyayı silin!

### 2. İlk Ürünleri Ekleyin

**Manuel Ekleme:**
Admin Panel → Ürünler → Yeni Ürün Ekle

**JSON Import (Web Scraper'dan):**
1. `products_database.json` dosyasını hazırlayın
2. Admin Panel → JSON Import
3. Dosyayı seçin ve yükleyin

### 3. Kategorileri Düzenleyin

Admin Panel → Kategoriler

Varsayılan kategoriler:
- Koltuk Takımı
- Yatak Odası
- Yemek Odası
- Genç Odası
- TV Ünitesi

Yeni kategori ekleyebilir veya düzenleyebilirsiniz.

---

## 🤖 Cronjob Kurulumu (Otomatik Import)

### cPanel Cron Jobs

1. cPanel → **Cron Jobs**
2. **Add New Cron Job**
3. Ayarları yapın:

```
Common Settings: Once Per Day (3am)
Minute: 0
Hour: 3
Day: *
Month: *
Weekday: *

Command: /usr/bin/php /home/USERNAME/public_html/cron/auto-import.php
```

**USERNAME** yerine cPanel kullanıcı adınızı yazın.

### Test Etme

SSH veya Terminal Access ile:

```bash
cd /home/USERNAME/public_html/cron
php auto-import.php
```

Log kontrol:
```bash
tail -f ../logs/auto-import-*.log
```

---

## 🔧 İleri Düzey Ayarlar

### SSL Kurulumu (Önerilir)

cPanel → SSL/TLS Status → AutoSSL

veya

Let's Encrypt ile:
```bash
certbot --apache -d yourdomain.com
```

### .htaccess HTTPS Zorla

`.htaccess` dosyasında yorum satırını kaldırın:

```apache
# RewriteCond %{HTTPS} off
# RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

Şu hale getirin:

```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### PHP Ayarları Optimizasyonu

cPanel → Select PHP Version → Switch to PHP Options

```
upload_max_filesize = 10M
post_max_size = 12M
max_execution_time = 300
memory_limit = 256M
```

---

## ✅ Kurulum Kontrol Listesi

### Temel Kurulum
- [ ] Dosyalar yüklendi
- [ ] Veritabanı oluşturuldu
- [ ] Tablolar import edildi
- [ ] Config dosyası düzenlendi
- [ ] İzinler ayarlandı
- [ ] Website açılıyor
- [ ] Admin panel çalışıyor

### Güvenlik
- [ ] Admin şifresi değiştirildi
- [ ] Database şifresi güçlü
- [ ] SSL kuruldu (HTTPS)
- [ ] Error reporting kapatıldı (production)

### İçerik
- [ ] Kategoriler düzenlendi
- [ ] İlk ürünler eklendi
- [ ] Logo yüklendi
- [ ] Site bilgileri güncellendi

### Otomasyon
- [ ] Cronjob kuruldu
- [ ] Cronjob test edildi
- [ ] Scraper output konumu ayarlandı

---

## 🆘 Sorun Giderme

### "Veritabanı bağlantı hatası"

**Çözüm:**
1. `config.php` dosyasını kontrol edin
2. Database adı doğru mu?
3. Kullanıcı adı doğru mu?
4. Şifrede özel karakter var mı? Escape edin.

```php
define('DB_PASS', 'my@password');  // YANLIŞ
define('DB_PASS', 'my@password');  // DOĞRU (PHP'de escape gerekmez)
```

### "Admin panel 404"

**Çözüm:**
1. `admin/` klasörü var mı kontrol edin
2. File Manager'da doğru yere yüklendiğinden emin olun
3. URL doğru mu: `yourdomain.com/admin/` (slash önemli)

### "Ürünler görünmüyor"

**Çözüm:**
1. phpMyAdmin → SQL:
```sql
SELECT COUNT(*) FROM products WHERE status = 1;
```
2. Sayı 0 ise ürün eklemediniz
3. Admin panel → JSON Import ile toplu ekleyin

### "Cronjob çalışmıyor"

**Çözüm:**
1. Path doğru mu kontrol edin:
```bash
which php
# Output: /usr/bin/php veya /usr/local/bin/php
```

2. Cronjob komutunu buna göre düzenleyin:
```
/usr/bin/php /home/USERNAME/public_html/cron/auto-import.php
```

3. Log dosyasını kontrol edin:
```bash
cat logs/auto-import-*.log
```

### "Resimler yüklenmiyor"

**Çözüm:**
1. `uploads/` klasörü var mı?
2. İzinler 755 mi?
```bash
chmod 755 uploads/
chmod 755 uploads/products/
```

3. PHP upload limiti yeterli mi?
```
upload_max_filesize = 10M
post_max_size = 12M
```

---

## 📞 Destek

### Log Dosyaları
- `logs/auto-import-YYYY-MM-DD.log` - Cronjob logları
- `logs/error.log` - PHP hataları

### Debug Modu

`config.php` dosyasında:

```php
// Geliştirme ortamı için
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Production ortamı için (kurulum sonrası)
error_reporting(0);
ini_set('display_errors', 0);
```

### Yardım

Sorun yaşarsanız:
1. Hata mesajını kopyalayın
2. Log dosyalarını kontrol edin
3. README.md ve bu dökümanı okuyun

---

## 🎉 Kurulum Tamamlandı!

Website: `https://yourdomain.com`
Admin Panel: `https://yourdomain.com/admin/`

**Sonraki Adımlar:**
1. Logo ve favicon ekleyin
2. Site renklerini özelleştirin
3. Ürünleri ekleyin
4. Test edin
5. Yayına alın!

**İyi satışlar! 🚀**
