<?php
// Admin authentication kontrolü
session_start();

// Kullanıcı giriş yapmış mı ve admin mi kontrol et
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Eğer admin değilse login sayfasına yönlendir
    header('Location: ../login.php?error=admin_required');
    exit();
}

// Admin bilgilerini al
$admin_name = $_SESSION['full_name'] ?? $_SESSION['username'];
$admin_email = $_SESSION['email'] ?? '';
?>
