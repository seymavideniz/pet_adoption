<?php
// Sayfa başlığını tanımla
$page_title = 'İletişim';

// Değişkenleri başlat
$success_message = '';
$error_message = '';
$name = '';
$email = '';
$message = '';

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Form verilerini al ve sanitize et
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Hata dizisi
    $errors = [];
    
    // Validasyon
    if (empty($name)) {
        $errors['name'] = 'Adınız ve soyadınız gereklidir.';
    } elseif (strlen($name) < 3) {
        $errors['name'] = 'Adınız en az 3 karakter olmalıdır.';
    }
    
    if (empty($email)) {
        $errors['email'] = 'E-posta adresi gereklidir.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Geçerli bir e-posta adresi giriniz.';
    }
    
    if (empty($message)) {
        $errors['message'] = 'Mesaj alanı gereklidir.';
    } elseif (strlen($message) < 10) {
        $errors['message'] = 'Mesajınız en az 10 karakter olmalıdır.';
    }
    
    // Hata yoksa işlemi tamamla
    if (empty($errors)) {
        // Burada normalde veritabanına kayıt yapılır veya e-posta gönderilir
        // Örnek amaçlı sadece başarı mesajı gösteriyoruz
        
        $success_message = 'Mesajınız başarıyla gönderildi! En kısa sürede sizinle iletişime geçeceğiz.';
        
        // Formu temizle
        $name = '';
        $email = '';
        $message = '';
    } else {
        $error_message = 'Lütfen formdaki hataları düzeltin.';
    }
}

// URL'den evcil hayvan bilgilerini al (sahiplen.php'den geliyorsa)
$pet_id = $_GET['pet_id'] ?? '';
$pet_name = $_GET['pet_name'] ?? '';

if (!empty($pet_name)) {
    $message = "Merhaba, " . htmlspecialchars($pet_name) . " isimli evcil hayvanı sahiplenmek istiyorum. Detaylı bilgi alabilir miyim?";
}

// Header dosyasını dahil et
require_once 'includes/header.php';
?>

<main>
    <!-- Hero Section -->
    <section class="page-hero">
        <div class="container">
            <h1 class="page-hero-title">Bizimle İletişime Geçin</h1>
            <p class="page-hero-subtitle">
                Bir dost sahiplenmek veya destek almak için bize yazın. Uzman ekibimiz ve gönüllülerimiz size yardımcı olmaktan mutluluk duyacaktır.
            </p>
        </div>
    </section>

    <div class="container">

        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <div class="contact-container">
            <!-- İletişim Formu -->
            <section class="contact-form-section">
                <form method="POST" action="iletisim.php" style="background: white; padding: var(--spacing-lg); border-radius: var(--radius-lg); box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <!-- Ad Soyad -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            Ad Soyad
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            class="form-input <?php echo isset($errors['name']) ? 'error' : ''; ?>"
                            value="<?php echo htmlspecialchars($name); ?>"
                            placeholder="İsminizi giriniz"
                            required
                        >
                        <?php if (isset($errors['name'])): ?>
                            <span class="form-error"><?php echo htmlspecialchars($errors['name']); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- E-posta -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            E-posta
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input <?php echo isset($errors['email']) ? 'error' : ''; ?>"
                            value="<?php echo htmlspecialchars($email); ?>"
                            placeholder="ornek@email.com"
                            required
                        >
                        <?php if (isset($errors['email'])): ?>
                            <span class="form-error"><?php echo htmlspecialchars($errors['email']); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Mesaj -->
                    <div class="form-group">
                        <label for="message" class="form-label">
                            Mesajınız
                        </label>
                        <textarea 
                            id="message" 
                            name="message" 
                            class="form-textarea <?php echo isset($errors['message']) ? 'error' : ''; ?>"
                            placeholder="Size nasıl yardımcı olabiliriz?"
                            required
                            style="min-height: 150px;"
                        ><?php echo htmlspecialchars($message); ?></textarea>
                        <?php if (isset($errors['message'])): ?>
                            <span class="form-error"><?php echo htmlspecialchars($errors['message']); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Gönder Butonu -->
                    <button type="submit" class="btn-submit">
                        GÖNDER
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </form>
            </section>

            <!-- İletişim Bilgileri -->
            <section class="contact-info-section">
                <!-- Adres Kartı -->
                <div class="contact-info-card">
                    <div class="contact-info-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="contact-info-content">
                        <div class="contact-info-label">ADRESİMİZ</div>
                        <div class="contact-info-value">Pati Sokak No:12, Kadıköy, İstanbul</div>
                    </div>
                </div>

                <!-- Telefon Kartı -->
                <div class="contact-info-card">
                    <div class="contact-info-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <div class="contact-info-content">
                        <div class="contact-info-label">TELEFON</div>
                        <div class="contact-info-value">+90 (212) 555 01 23</div>
                    </div>
                </div>

                <!-- E-posta Kartı -->
                <div class="contact-info-card">
                    <div class="contact-info-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="contact-info-content">
                        <div class="contact-info-label">E-POSTA</div>
                        <div class="contact-info-value">info@patikapisi.com</div>
                    </div>
                </div>

                <!-- Görsel Kartı -->
                <div class="contact-image-card">
                    <img src="assets/images/contact-dog.jpg" alt="Evcil Hayvan" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div style="display: none; width: 100%; height: 100%; align-items: center; justify-content: center; font-size: 5rem;">
                        🐶
                    </div>
                    <div class="contact-image-text">
                        Onlar için en iyisini birlikte yapabiliriz.
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

<?php
// Footer dosyasını dahil et
require_once 'includes/footer.php';
?>
