<?php
require_once 'includes/db.php';

$email = 'test@test.com';
$password = '123456';
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Önce varsa sil
try {
    $pdo->exec("DELETE FROM users WHERE email = '$email'");
    
    // Yeni kullanıcı ekle
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, full_name, role, created_at) VALUES (?, ?, ?, ?, 'user', NOW())");
    $stmt->execute(['testuser', $email, $hashed, 'Test Kullanıcı']);
    
    echo "<h2>✓ Test kullanıcısı oluşturuldu!</h2>";
    echo "<p><strong>E-posta:</strong> test@test.com</p>";
    echo "<p><strong>Şifre:</strong> 123456</p>";
    echo "<br>";
    echo "<a href='login.php' style='background: #705738; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Giriş Sayfasına Git</a>";
    echo "<br><br>";
    echo "<p style='color: red;'><strong>ÖNEMLİ:</strong> Bu dosyayı (create_test_user.php) şimdi silin!</p>";
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>
