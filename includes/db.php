<?php
/**
 * Veritabanı Bağlantı Dosyası
 * PDO (PHP Data Objects) kullanarak MySQL veritabanına güvenli bağlantı sağlar
 * SQL Injection saldırılarına karşı prepared statements kullanır
 * 
 * Not: Bu dosya config.php'den yapılandırma değerlerini alır
 * config.php ise .env dosyasından değerleri okur
 */

// Yapılandırma dosyasını dahil et
require_once __DIR__ . '/../config.php';

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
    if (APP_ENV === 'development') {
        die("Veritabanı bağlantı hatası: " . $e->getMessage());
    } else {
        die("Veritabanı bağlantı hatası oluştu. Lütfen daha sonra tekrar deneyin.");
    }
}
