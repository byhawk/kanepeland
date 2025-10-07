<?php
// Evantis Home - Sistem Kontrol Sayfası
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evantis Home - Sistem Kontrolü</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        .header {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .header h1 {
            color: #2B3A55;
            margin-bottom: 10px;
        }
        .header p {
            color: #666;
        }
        .box {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .box h2 {
            color: #2B3A55;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #B18A5E;
        }
        .success {
            color: #27ae60;
            padding: 8px 0;
            font-size: 14px;
        }
        .error {
            color: #e74c3c;
            padding: 8px 0;
            font-weight: 600;
            font-size: 14px;
        }
        .warning {
            color: #f39c12;
            padding: 8px 0;
            font-size: 14px;
        }
        .info {
            color: #3498db;
            padding: 8px 0;
            font-size: 14px;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
            margin-left: 10px;
        }
        .badge-success { background: #27ae60; color: white; }
        .badge-error { background: #e74c3c; color: white; }
        .badge-warning { background: #f39c12; color: white; }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 5px;
            background: #B18A5E;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .btn:hover {
            background: #D1AF84;
            transform: translateY(-2px);
        }
        .progress {
            background: #ecf0f1;
            height: 30px;
            border-radius: 15px;
            overflow: hidden;
            margin: 20px 0;
        }
        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #27ae60, #2ecc71);
            text-align: center;
            line-height: 30px;
            color: white;
            font-weight: bold;
            transition: width 0.5s;
        }
        ol { margin-left: 20px; }
        ol li { margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔍 Evantis Home Sistem Kontrolü</h1>
            <p>Kurulum durumunu kontrol edin</p>
        </div>

        <?php
        $total_checks = 0;
        $passed_checks = 0;

        // 1. Dosya Yapısı Kontrolü
        $critical_files = [
            'includes/config.php' => 'Yapılandırma dosyası',
            'includes/functions.php' => 'Yardımcı fonksiyonlar',
            'includes/header.php' => 'Site başlığı',
            'includes/footer.php' => 'Site alt bilgi',
            'admin/login.php' => 'Admin giriş sayfası',
            'index.php' => 'Ana sayfa',
            'products.php' => 'Ürünler sayfası',
            'product.php' => 'Ürün detay sayfası',
            'assets/css/style.css' => 'Stil dosyası',
            'assets/js/main.js' => 'JavaScript dosyası',
            'database/schema-cpanel.sql' => 'Veritabanı şeması'
        ];
        ?>

        <div class="box">
            <h2>1️⃣ Dosya Yapısı Kontrolü</h2>
            <?php
            $file_count = count($critical_files);
            $file_found = 0;

            foreach($critical_files as $file => $desc) {
                $total_checks++;
                if(file_exists($file)) {
                    echo "<p class='success'>✅ <strong>$file</strong> - $desc</p>";
                    $file_found++;
                    $passed_checks++;
                } else {
                    echo "<p class='error'>❌ <strong>$file</strong> - BULUNAMADI! ($desc)</p>";
                }
            }

            $file_percent = round(($file_found / $file_count) * 100);
            echo "<div class='progress'>";
            echo "<div class='progress-bar' style='width: {$file_percent}%'>{$file_percent}% Tamamlandı</div>";
            echo "</div>";
            ?>
        </div>

        <div class="box">
            <h2>2️⃣ Dizin Kontrolü ve İzinler</h2>
            <?php
            $required_dirs = [
                'uploads' => ['desc' => 'Yükleme klasörü', 'required' => true],
                'logs' => ['desc' => 'Log dosyaları', 'required' => true],
                'scraper-data' => ['desc' => 'Scraper çıktıları', 'required' => false],
                'admin' => ['desc' => 'Admin paneli', 'required' => true],
                'assets' => ['desc' => 'CSS/JS dosyaları', 'required' => true],
                'includes' => ['desc' => 'PHP includes', 'required' => true]
            ];

            foreach($required_dirs as $dir => $info) {
                $total_checks++;
                if(is_dir($dir)) {
                    $perms = substr(sprintf('%o', fileperms($dir)), -4);
                    $writable = is_writable($dir);

                    if($writable) {
                        echo "<p class='success'>✅ <strong>$dir/</strong> - {$info['desc']} (İzin: $perms) <span class='badge badge-success'>YAZILIR</span></p>";
                        $passed_checks++;
                    } else {
                        echo "<p class='warning'>⚠️ <strong>$dir/</strong> - {$info['desc']} (İzin: $perms) <span class='badge badge-warning'>SALT OKUNUR</span></p>";
                        if($info['required']) {
                            echo "<p class='error' style='margin-left: 20px;'>→ Bu klasör yazılabilir olmalı! chmod 755 yapın</p>";
                        }
                    }
                } else {
                    if($info['required']) {
                        echo "<p class='error'>❌ <strong>$dir/</strong> - Klasör bulunamadı! ({$info['desc']})</p>";
                    } else {
                        echo "<p class='warning'>⚠️ <strong>$dir/</strong> - Klasör yok (opsiyonel)</p>";
                        $passed_checks++;
                    }
                }
            }
            ?>
        </div>

        <div class="box">
            <h2>3️⃣ PHP ve Sunucu Bilgileri</h2>
            <p class="info">📌 <strong>PHP Versiyonu:</strong> <?php echo PHP_VERSION; ?>
                <?php if(version_compare(PHP_VERSION, '7.4.0') >= 0): ?>
                    <span class='badge badge-success'>UYGUN</span>
                <?php else: ?>
                    <span class='badge badge-error'>ESKİ VERSİYON</span>
                <?php endif; ?>
            </p>
            <p class="info">📁 <strong>Mevcut Dizin:</strong> <?php echo __DIR__; ?></p>
            <p class="info">🖥️ <strong>Server:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Bilinmiyor'; ?></p>
            <p class="info">🌐 <strong>Host:</strong> <?php echo $_SERVER['HTTP_HOST'] ?? 'Bilinmiyor'; ?></p>

            <?php
            $extensions = ['pdo', 'pdo_mysql', 'json', 'mbstring', 'zip'];
            echo "<p class='info'><strong>📦 PHP Eklentileri:</strong></p>";
            foreach($extensions as $ext) {
                $total_checks++;
                if(extension_loaded($ext)) {
                    echo "<p class='success' style='margin-left: 20px;'>✅ $ext</p>";
                    $passed_checks++;
                } else {
                    echo "<p class='error' style='margin-left: 20px;'>❌ $ext - Yüklü değil!</p>";
                }
            }
            ?>
        </div>

        <div class="box">
            <h2>4️⃣ Veritabanı Bağlantısı</h2>
            <?php
            $total_checks++;
            if(file_exists('includes/config.php')) {
                require_once 'includes/config.php';

                try {
                    $test_db = new PDO(
                        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                        DB_USER,
                        DB_PASS
                    );
                    echo "<p class='success'>✅ Veritabanı bağlantısı başarılı!</p>";
                    echo "<p class='info'>📊 <strong>Database:</strong> " . DB_NAME . "</p>";
                    echo "<p class='info'>👤 <strong>User:</strong> " . DB_USER . "</p>";

                    // Tablo kontrolü
                    $tables = $test_db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
                    if(count($tables) > 0) {
                        echo "<p class='success'>✅ " . count($tables) . " tablo bulundu</p>";
                        echo "<p class='info' style='margin-left: 20px;'>" . implode(', ', $tables) . "</p>";
                    } else {
                        echo "<p class='warning'>⚠️ Veritabanı boş! schema-cpanel.sql dosyasını import edin.</p>";
                    }
                    $passed_checks++;
                } catch(PDOException $e) {
                    echo "<p class='error'>❌ Veritabanı bağlantı hatası: " . $e->getMessage() . "</p>";
                    echo "<p class='warning'>→ config.php dosyasını kontrol edin</p>";
                }
            } else {
                echo "<p class='error'>❌ config.php dosyası bulunamadı!</p>";
            }
            ?>
        </div>

        <div class="box">
            <h2>5️⃣ URL Testleri</h2>
            <p class="info">Test sayfalarını açarak kontrol edin:</p>
            <div style="margin-top: 15px;">
                <a href="index.php" class="btn" target="_blank">🏠 Ana Sayfa</a>
                <a href="products.php" class="btn" target="_blank">📦 Ürünler</a>
                <a href="admin/login.php" class="btn" target="_blank">🔐 Admin Panel</a>
            </div>
        </div>

        <div class="box">
            <h2>📊 Genel Sonuç</h2>
            <?php
            $success_rate = round(($passed_checks / $total_checks) * 100);
            echo "<div class='progress'>";
            echo "<div class='progress-bar' style='width: {$success_rate}%'>{$success_rate}%</div>";
            echo "</div>";

            echo "<p class='info'><strong>Toplam Kontrol:</strong> $total_checks</p>";
            echo "<p class='success'><strong>Başarılı:</strong> $passed_checks</p>";
            echo "<p class='error'><strong>Başarısız:</strong> " . ($total_checks - $passed_checks) . "</p>";

            if($success_rate >= 90) {
                echo "<p class='success' style='font-size: 18px; margin-top: 20px;'>🎉 <strong>Harika! Sistem hazır.</strong></p>";
            } elseif($success_rate >= 70) {
                echo "<p class='warning' style='font-size: 18px; margin-top: 20px;'>⚠️ <strong>Neredeyse hazır! Bazı düzeltmeler gerekli.</strong></p>";
            } else {
                echo "<p class='error' style='font-size: 18px; margin-top: 20px;'>❌ <strong>Kurulum tamamlanmamış! Lütfen kontrol edin.</strong></p>";
            }
            ?>
        </div>

        <div class="box">
            <h2>✅ Yapılacaklar Listesi</h2>
            <ol>
                <li><strong>Dosyalar:</strong> Tüm dosyaların public_html ana dizininde olduğundan emin olun</li>
                <li><strong>Veritabanı:</strong> cPanel → MySQL Databases → Yeni database oluşturun</li>
                <li><strong>Import:</strong> phpMyAdmin → database/schema-cpanel.sql dosyasını import edin</li>
                <li><strong>Config:</strong> includes/config.php dosyasında database bilgilerini düzenleyin</li>
                <li><strong>İzinler:</strong> uploads/, logs/ klasörlerine 755 izni verin</li>
                <li><strong>Test:</strong> Yukarıdaki butonlarla sayfaları test edin</li>
                <li><strong>Sil:</strong> Her şey çalışıyorsa bu test.php dosyasını silin!</li>
            </ol>
        </div>

        <div class="box" style="background: #f8f9fa; border: 2px solid #B18A5E;">
            <h2>🔐 Admin Giriş Bilgileri</h2>
            <p class="info"><strong>URL:</strong> <a href="admin/login.php">admin/login.php</a></p>
            <p class="info"><strong>Kullanıcı:</strong> admin</p>
            <p class="info"><strong>Şifre:</strong> admin123</p>
            <p class="warning">⚠️ İlk girişten sonra mutlaka şifrenizi değiştirin!</p>
        </div>
    </div>
</body>
</html>
