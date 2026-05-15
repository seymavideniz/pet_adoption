<?php
// Sayfa başlığını tanımla
$page_title = 'Kayıt Ol';

// Değişkenleri başlat
$success_message = '';
$error_message = '';
$name = '';
$email = '';

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Form verilerini al ve sanitize et
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $password_confirm = trim($_POST['password_confirm'] ?? '');
    
    // Hata dizisi
    $errors = [];
    
    // Validasyon
    if (empty($name)) {
        $errors['name'] = 'Ad soyad gereklidir.';
    } elseif (strlen($name) < 3) {
        $errors['name'] = 'Adınız en az 3 karakter olmalıdır.';
    }
    
    if (empty($email)) {
        $errors['email'] = 'E-posta adresi gereklidir.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Geçerli bir e-posta adresi giriniz.';
    }
    
    if (empty($password)) {
        $errors['password'] = 'Şifre gereklidir.';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Şifre en az 6 karakter olmalıdır.';
    }
    
    if ($password !== $password_confirm) {
        $errors['password_confirm'] = 'Şifreler eşleşmiyor.';
    }
    
    // Hata yoksa kayıt işlemini tamamla
    if (empty($errors)) {
        // Burada normalde veritabanına kayıt yapılır
        $success_message = 'Kayıt işleminiz başarıyla tamamlandı! Giriş yapabilirsiniz.';
        $name = '';
        $email = '';
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

        <!-- Sağ Taraf - Kayıt Formu -->
        <div class="login-form-section">
            <div class="login-form-wrapper">
                <!-- Logo İkonu -->
                <div class="login-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="#8B7355">
                        <path d="M4.5 12c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5zm13.5 0c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8 0-1.85.63-3.55 1.69-4.9L16.9 18.31C15.55 19.37 13.85 20 12 20z"/>
                    </svg>
                </div>

                <h1 class="login-title">Kayıt Olun</h1>
                <p class="login-subtitle">Yeni bir hesap oluşturun.</p>

                <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success" style="margin-bottom: var(--spacing-md);">
                        <?php echo htmlspecialchars($success_message); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="register.php" class="login-form">
                    <!-- Ad Soyad -->
                    <div class="form-group">
                        <label for="name" class="form-label">Ad Soyad</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            class="form-input <?php echo isset($errors['name']) ? 'error' : ''; ?>"
                            value="<?php echo htmlspecialchars($name); ?>"
                            placeholder="Adınız ve soyadınız"
                            required
                        >
                        <?php if (isset($errors['name'])): ?>
                            <span class="form-error"><?php echo htmlspecialchars($errors['name']); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- E-posta -->
                    <div class="form-group">
                        <label for="email" class="form-label">E-posta Adresi</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input <?php echo isset($errors['email']) ? 'error' : ''; ?>"
                            value="<?php echo htmlspecialchars($email); ?>"
                            placeholder="ornek@eposta.com"
                            required
                        >
                        <?php if (isset($errors['email'])): ?>
                            <span class="form-error"><?php echo htmlspecialchars($errors['email']); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Şifre -->
                    <div class="form-group">
                        <label for="password" class="form-label">Şifre</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input <?php echo isset($errors['password']) ? 'error' : ''; ?>"
                            placeholder="En az 6 karakter"
                            required
                        >
                        <?php if (isset($errors['password'])): ?>
                            <span class="form-error"><?php echo htmlspecialchars($errors['password']); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Şifre Tekrar -->
                    <div class="form-group">
                        <label for="password_confirm" class="form-label">Şifre (Tekrar)</label>
                        <input 
                            type="password" 
                            id="password_confirm" 
                            name="password_confirm" 
                            class="form-input <?php echo isset($errors['password_confirm']) ? 'error' : ''; ?>"
                            placeholder="Şifrenizi tekrar girin"
                            required
                        >
                        <?php if (isset($errors['password_confirm'])): ?>
                            <span class="form-error"><?php echo htmlspecialchars($errors['password_confirm']); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Kayıt Butonu -->
                    <button type="submit" class="btn-submit btn-submit-full">
                        KAYIT OL
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </form>

                <!-- Giriş Yap Linki -->
                <div class="login-footer">
                    <p>Zaten hesabınız var mı? <a href="login.php" class="register-link">Giriş Yapın</a></p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
// Footer dosyasını dahil et
require_once 'includes/footer.php';
?>
