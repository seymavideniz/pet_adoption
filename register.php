<?php
// Sayfa başlığını tanımla
$page_title = 'Kayıt Ol';

// Veritabanı bağlantısı
require_once 'includes/db.php';

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
        try {
            // Email zaten kayıtlı mı kontrol et
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() > 0) {
                $errors['email'] = 'Bu e-posta adresi zaten kayıtlı.';
            } else {
                // Şifreyi hashle
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Kullanıcı adı oluştur (email'den)
                $username = explode('@', $email)[0];
                
                // Veritabanına kaydet
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, full_name, role, created_at) VALUES (?, ?, ?, ?, 'user', NOW())");
                $stmt->execute([$username, $email, $hashed_password, $name]);
                
                $success_message = 'Kayıt işleminiz başarıyla tamamlandı! Giriş yapabilirsiniz.';
                $name = '';
                $email = '';
            }
        } catch (PDOException $e) {
            $error_message = 'Kayıt sırasında bir hata oluştu. Lütfen tekrar deneyin.';
        }
    }
}

// Header dosyasını dahil et
require_once 'includes/header.php';
?>

<main class="login-page">
    <div class="login-container">
        <!-- Sol Taraf - Görsel ve Metin -->
        <div class="login-image-section" style="background-image: url('assets/images/girisyap.JPG');">
            <div class="login-image-content">
                <h2 class="login-image-title" style="color: #FFDDB7; text-shadow: 2px 2px 8px rgba(0,0,0,0.8), 0 0 20px rgba(0,0,0,0.5);">Yeni bir dost,<br>yeni bir hikaye.</h2>
            </div>
        </div>

        <!-- Sağ Taraf - Kayıt Formu -->
        <div class="login-form-section">
            <div class="login-form-wrapper">
                <!-- Logo İkonu -->
                <div class="login-icon">
                    <img src="assets/images/ikon.JPG" alt="Logo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </div>

                <h1 class="login-title">Kayıt Olun</h1>
                <p class="login-subtitle">Yeni bir hesap oluşturun.</p>

                <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success" style="margin-bottom: var(--spacing-md);">
                        <?php echo htmlspecialchars($success_message); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-error" style="margin-bottom: var(--spacing-md);">
                        <?php echo htmlspecialchars($error_message); ?>
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
                            class="simple-input <?php echo isset($errors['name']) ? 'error' : ''; ?>"
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
                            class="simple-input <?php echo isset($errors['email']) ? 'error' : ''; ?>"
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
                            class="simple-input <?php echo isset($errors['password']) ? 'error' : ''; ?>"
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
                            class="simple-input <?php echo isset($errors['password_confirm']) ? 'error' : ''; ?>"
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
