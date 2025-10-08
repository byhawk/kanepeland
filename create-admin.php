<?php
// Admin User Creator
// Bu dosyayı bir kez çalıştır, sonra sil!

require_once 'includes/config.php';

try {
    // Admin şifresini hash'le
    $password_hash = password_hash('admin123', PASSWORD_DEFAULT);

    // Önce var olan admin kullanıcısını sil
    $db->exec("DELETE FROM admin_users WHERE username = 'admin'");

    // Yeni admin kullanıcısı ekle
    $stmt = $db->prepare("
        INSERT INTO admin_users (username, password, email, full_name, role, status)
        VALUES ('admin', :password, 'admin@evantishome.com', 'Admin User', 'admin', 1)
    ");

    $stmt->execute([':password' => $password_hash]);

    echo "✅ Admin kullanıcısı başarıyla oluşturuldu!<br><br>";
    echo "<strong>Giriş Bilgileri:</strong><br>";
    echo "Kullanıcı Adı: <code>admin</code><br>";
    echo "Şifre: <code>admin123</code><br><br>";
    echo "<a href='admin/login.php'>Admin Panele Git →</a><br><br>";
    echo "<hr>";
    echo "<small style='color: red;'>⚠️ GÜVENLİK: Bu dosyayı şimdi silin!</small>";

} catch (PDOException $e) {
    echo "❌ Hata: " . $e->getMessage();
    echo "<br><br>";
    echo "<strong>Çözüm:</strong> Veritabanını kontrol edin. admin_users tablosu var mı?";
}
?>
