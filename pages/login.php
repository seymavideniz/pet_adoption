<?php
/**
 * Giriş Sayfası (login.php)
 * Kullanıcı kimlik doğrulama işlemlerini yönetir
 * Email/username ve şifre kontrolü yapar
 */

// Sayfa başlığını tanımla
$page_title = 'Giriş Yap';

// Session başlat
session_start();

// Veritabanı bağlantısı
require_once '../includes/db.php';

// Form değişkenlerini başlat
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
        try {
            // Kullanıcıyı veritabanından bul
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
            $stmt->execute([$email, $email]);
            $user = $stmt->fetch();
            
            // Kullanıcı bulundu mu ve şifre doğru mu kontrol et
            if ($user && password_verify($password, $user['password'])) {
                // Giriş başarılı - Session oluştur
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];
                
                // Remember me özelliği
                if ($remember) {
                    setcookie('user_email', $email, time() + (86400 * 30), '/'); // 30 gün
                }
                
                // Admin ise admin paneline, değilse anasayfaya yönlendir
                if ($user['role'] == 'admin') {
                    header('Location: ../admin/dashboard.php');
                } else {
                    header('Location: ../index.php');
                }
                exit();
            } else {
                $error_message = 'E-posta veya şifre hatalı.';
            }
        } catch (PDOException $e) {
            $error_message = 'Bir hata oluştu. Lütfen tekrar deneyin.';
        }
    }
}

// Header dosyasını dahil et
require_once '../includes/header.php';
?>

<main class="login-page">
    <div class="login-container">
        <!-- Sol Taraf - Görsel ve Metin -->
        <div class="login-image-section" style="background-image: url('../assets/images/girisyap.jpg');">
            <div class="login-image-content">
                <h2 class="login-image-title">Yeni bir dost,<br>yeni bir hikaye.</h2>
            </div>
        </div>

        <!-- Sağ Taraf - Giriş Formu -->
        <div class="login-form-section">
            <div class="login-form-wrapper">
                <!-- Logo İkonu -->
                <div class="login-icon">
                    <img src="../assets/images/ikon.jpg" alt="PatiKapısı Logo">
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
                        <div class="form-label-row">
                            <label for="password" class="form-label">Şifre</label>
                            <a href="#" class="forgot-password-link">Şifremi Unuttum</a>
                        </div>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="simple-input <?php echo isset($errors['password']) ? 'error' : ''; ?>"
                            placeholder="••••••••"
                            required
                        >
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
require_once '../includes/footer.php';
?>
