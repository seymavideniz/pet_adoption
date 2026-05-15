<?php
// Sayfa başlığını tanımla
$page_title = 'Giriş Yap';

// Değişkenleri başlat
$error_message = '';
$email = '';

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Form verilerini al ve sanitize et
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $remember = isset($_POST['remember']) ? true : false;
    
    // Hata dizisi
    $errors = [];
    
    // Validasyon
    if (empty($email)) {
        $errors['email'] = 'E-posta adresi gereklidir.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Geçerli bir e-posta adresi giriniz.';
    }
    
    if (empty($password)) {
        $errors['password'] = 'Şifre gereklidir.';
    }
    
    // Hata yoksa giriş işlemini kontrol et
    if (empty($errors)) {
        // Burada normalde veritabanından kullanıcı kontrolü yapılır
        // Örnek amaçlı sadece hata mesajı gösteriyoruz
        $error_message = 'E-posta veya şifre hatalı.';
    }
}

// Header dosyasını dahil et
require_once 'includes/header.php';
?>

<main class="login-page">
    <div class="login-container">
        <!-- Sol Taraf - Görsel ve Metin -->
        <div class="login-image-section">
            <div class="login-image-content">
                <h2 class="login-image-title">Yeni bir dost,<br>yeni bir hikaye.</h2>
            </div>
        </div>

        <!-- Sağ Taraf - Giriş Formu -->
        <div class="login-form-section">
            <div class="login-form-wrapper">
                <!-- Logo İkonu -->
                <div class="login-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="#8B7355">
                        <path d="M4.5 12c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5zm13.5 0c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8 0-1.85.63-3.55 1.69-4.9L16.9 18.31C15.55 19.37 13.85 20 12 20z"/>
                    </svg>
                </div>

                <h1 class="login-title">Hoş Geldiniz</h1>
                <p class="login-subtitle">Lütfen hesabınıza giriş yapın.</p>

                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-error" style="margin-bottom: var(--spacing-md);">
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="login.php" class="login-form">
                    <!-- E-posta -->
                    <div class="form-group">
                        <label for="email" class="form-label">E-posta Adresi</label>
                        <div class="form-input-wrapper">
                            <span class="form-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-input form-input-with-icon <?php echo isset($errors['email']) ? 'error' : ''; ?>"
                                value="<?php echo htmlspecialchars($email); ?>"
                                placeholder="ornek@eposta.com"
                                required
                            >
                        </div>
                        <?php if (isset($errors['email'])): ?>
                            <span class="form-error"><?php echo htmlspecialchars($errors['email']); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Şifre -->
                    <div class="form-group">
                        <div class="form-label-row">
                            <label for="password" class="form-label">Şifre</label>
                            <a href="#" class="forgot-password-link">Şifremi Unuttum</a>
                        </div>
                        <div class="form-input-wrapper">
                            <span class="form-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0110 0v4"></path>
                                </svg>
                            </span>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-input form-input-with-icon <?php echo isset($errors['password']) ? 'error' : ''; ?>"
                                placeholder="••••••••"
                                required
                            >
                        </div>
                        <?php if (isset($errors['password'])): ?>
                            <span class="form-error"><?php echo htmlspecialchars($errors['password']); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Beni Hatırla -->
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" class="checkbox-input">
                            <span class="checkbox-text">Beni hatırla</span>
                        </label>
                    </div>

                    <!-- Giriş Butonu -->
                    <button type="submit" class="btn-submit btn-submit-full">
                        GİRİŞ YAP
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </form>

                <!-- Kayıt Ol Linki -->
                <div class="login-footer">
                    <p>Hesabınız yok mu? <a href="register.php" class="register-link">Hemen Kayıt Olun</a></p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
// Footer dosyasını dahil et
require_once 'includes/footer.php';
?>
