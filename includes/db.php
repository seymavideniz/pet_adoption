<?php
/**
 * Veritabanı Bağlantı Dosyası
 * PDO kullanarak MySQL veritabanına güvenli bağlantı sağlar
 */

// Hata raporlamayı aç (geliştirme aşamasında)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Veritabanı bağlantı bilgileri
define('DB_HOST', 'localhost');
define('DB_NAME', 'pet_adoption');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

try {
    // PDO örneği oluştur
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    
} catch (PDOException $e) {
    // Hata durumunda kullanıcı dostu mesaj göster
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
