<?php
/**
 * Yapılandırma Dosyası
 * .env dosyasından değerleri okur ve sabitleri tanımlar
 */

// .env dosyasını oku
function loadEnv($path) {
    if (!file_exists($path)) {
        return false;
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Yorumları ve boş satırları atla
        if (strpos(trim($line), '#') === 0 || empty(trim($line))) {
            continue;
        }
        
        // KEY=VALUE formatını parse et
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        
        // Ortam değişkenine kaydet
        if (!array_key_exists($key, $_ENV)) {
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
    return true;
}

// .env dosyasını yükle
$envPath = __DIR__ . '/.env';
loadEnv($envPath);

// Veritabanı sabitleri
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'pet_adoption');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_CHARSET', getenv('DB_CHARSET') ?: 'utf8mb4');

// Uygulama sabitleri
define('APP_ENV', getenv('APP_ENV') ?: 'development');
