<?php
// Admin hesabı oluşturma scripti - Sadece bir kere çalıştırılmalı
require_once 'includes/db.php';

// Admin kullanıcı bilgileri
$admin_username = 'admin';
$admin_email = 'admin@patikapisi.com';
$admin_password = 'admin123'; // Değiştirmeniz önerilir
$admin_full_name = 'Admin';

// Şifreyi hashle
$hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);

try {
    // Admin kullanıcısı var mı kontrol et
    $check_stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $check_stmt->execute([$admin_username, $admin_email]);
    
    if ($check_stmt->rowCount() > 0) {
        echo "Admin kullanıcısı zaten mevcut!<br>";
        echo "Kullanıcı adı: " . htmlspecialchars($admin_username) . "<br>";
        echo "E-posta: " . htmlspecialchars($admin_email) . "<br>";
    } else {
        // Admin kullanıcısını ekle
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, full_name, role, created_at) VALUES (?, ?, ?, ?, 'admin', NOW())");
        $stmt->execute([$admin_username, $admin_email, $hashed_password, $admin_full_name]);
        
        echo "<h2>✓ Admin hesabı başarıyla oluşturuldu!</h2>";
        echo "<p><strong>Kullanıcı adı:</strong> " . htmlspecialchars($admin_username) . "</p>";
        echo "<p><strong>E-posta:</strong> " . htmlspecialchars($admin_email) . "</p>";
        echo "<p><strong>Şifre:</strong> " . htmlspecialchars($admin_password) . "</p>";
        echo "<br>";
        echo "<p style='color: red;'><strong>ÖNEMLİ:</strong> Güvenlik için bu dosyayı (setup_admin.php) şimdi silin!</p>";
        echo "<br>";
        echo "<a href='login.php' style='background: #705738; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Giriş Sayfasına Git</a>";
    }
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>
