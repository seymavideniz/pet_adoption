<?php
// Sayfa başlığını tanımla
$page_title = 'PatiKapısı - Evcil Hayvan Sahiplendirme';

// Veritabanı bağlantısını dahil et
require_once 'includes/db.php';

// Veritabanından evcil hayvanları çek
try {
    $stmt = $pdo->prepare("SELECT * FROM pets WHERE status = 'Sahiplendirilebilir' ORDER BY id DESC LIMIT 6");
    $stmt->execute();
    $pets = $stmt->fetchAll();
} catch (PDOException $e) {
    $error_message = "Evcil hayvanlar yüklenirken bir hata oluştu: " . $e->getMessage();
    $pets = [];
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-variant": "#e9e1dc",
                        "tertiary-fixed-dim": "#c9c6c2",
                        "surface-container-highest": "#e9e1dc",
                        "outline": "#80756b",
                        "on-tertiary-fixed-variant": "#474743",
                        "on-secondary-container": "#716252",
                        "surface-bright": "#fff8f5",
                        "inverse-primary": "#e3c19a",
                        "on-secondary": "#ffffff",
                        "on-tertiary": "#ffffff",
                        "inverse-on-surface": "#f8efea",
                        "secondary": "#6b5c4c",
                        "on-error-container": "#93000a",
                        "surface-container-lowest": "#ffffff",
                        "primary-fixed-dim": "#e3c19a",
                        "on-background": "#1e1b18",
                        "primary-fixed": "#ffddb7",
                        "tertiary-fixed": "#e5e2dd",
                        "on-primary-fixed": "#2a1801",
                        "error-container": "#ffdad6",
                        "error": "#ba1a1a",
                        "on-surface": "#1e1b18",
                        "on-primary-fixed-variant": "#5a4225",
                        "on-surface-variant": "#4e453c",
                        "on-tertiary-container": "#fefbf6",
                        "surface-container": "#f5ece7",
                        "inverse-surface": "#34302c",
                        "secondary-container": "#f4dfcb",
                        "on-primary-container": "#fffbfa",
                        "primary": "#705738",
                        "secondary-fixed": "#f4dfcb",
                        "surface-tint": "#745a3a",
                        "surface": "#fff8f5",
                        "primary-container": "#8b6f4e",
                        "surface-container-high": "#efe6e2",
                        "on-secondary-fixed-variant": "#524436",
                        "on-error": "#ffffff",
                        "background": "#fff8f5",
                        "tertiary": "#5c5b58",
                        "surface-dim": "#e1d8d4",
                        "on-secondary-fixed": "#241a0e",
                        "tertiary-container": "#757470",
                        "secondary-fixed-dim": "#d7c3b0",
                        "on-primary": "#ffffff",
                        "outline-variant": "#d1c4b8",
                        "surface-container-low": "#fbf2ed",
                        "on-tertiary-fixed": "#1c1c19"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "xs": "4px",
                        "xl": "48px",
                        "md": "16px",
                        "gutter": "24px",
                        "container-max": "1280px",
                        "xxl": "80px",
                        "sm": "8px",
                        "unit": "4px",
                        "lg": "24px"
                    },
                    "fontFamily": {
                        "headline-xl": ["Manrope"],
                        "display-lg": ["Manrope"],
                        "body-lg": ["Manrope"],
                        "button": ["Manrope"],
                        "headline-lg": ["Manrope"],
                        "body-md": ["Manrope"],
                        "label-md": ["Manrope"]
                    },
                    "fontSize": {
                        "headline-xl": ["48px", {"lineHeight": "1.2", "fontWeight": "700"}],
                        "display-lg": ["64px", {"lineHeight": "1.1", "fontWeight": "800"}],
                        "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
                        "button": ["14px", {"lineHeight": "1", "letterSpacing": "0.1em", "fontWeight": "700"}],
                        "headline-lg": ["32px", {"lineHeight": "1.3", "fontWeight": "700"}],
                        "body-md": ["16px", {"lineHeight": "1.6", "fontWeight": "400"}],
                        "label-md": ["14px", {"lineHeight": "1.4", "letterSpacing": "0.05em", "fontWeight": "600"}]
                    }
                },
            },
        }
    </script>
    <style>
        html {
            scroll-behavior: smooth;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .soft-shadow {
            box-shadow: 0 20px 40px -20px rgba(112, 87, 56, 0.08);
        }
        /* Paw Cursor */
        * {
            cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32' fill='%238B6F47'%3E%3Cellipse cx='16' cy='20' rx='6' ry='8'/%3E%3Ccircle cx='10' cy='10' r='3'/%3E%3Ccircle cx='16' cy='8' r='3'/%3E%3Ccircle cx='22' cy='10' r='3'/%3E%3Ccircle cx='8' cy='16' r='3'/%3E%3C/svg%3E") 16 16, auto;
        }
        a, button {
            cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32' fill='%238B6F47'%3E%3Cellipse cx='16' cy='20' rx='6' ry='8'/%3E%3Ccircle cx='10' cy='10' r='3'/%3E%3Ccircle cx='16' cy='8' r='3'/%3E%3Ccircle cx='22' cy='10' r='3'/%3E%3Ccircle cx='8' cy='16' r='3'/%3E%3C/svg%3E") 16 16, pointer;
        }
        
        /* Smooth Nav Link Hover Effect */
        .nav-link-smooth {
            position: relative;
            transition: color 0.2s ease;
        }
        .nav-link-smooth::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #705738;
            transition: width 0.2s ease;
        }
        .nav-link-smooth:hover::after {
            width: 100%;
        }
        .nav-link-smooth:hover {
            color: #705738;
        }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md">
    <!-- Header (Fixed) -->
    <header class="bg-transparent fixed top-0 left-0 right-0 z-50 transition-colors duration-300" id="header">
        <div class="flex justify-between items-center max-w-[1280px] mx-auto px-gutter py-md">
            <div class="font-headline-lg text-headline-lg text-primary">
                <a href="#anasayfa">PatiKapısı</a>
            </div>
            <nav class="hidden md:flex gap-xl items-center">
                <a class="nav-link-smooth text-on-surface-variant font-body-md text-body-md" href="#anasayfa">Anasayfa</a>
                <a class="nav-link-smooth text-on-surface-variant font-body-md text-body-md" href="#sahiplen">Sahiplen</a>
                <a class="nav-link-smooth text-on-surface-variant font-body-md text-body-md" href="#hakkimizda">Hakkımızda</a>
                <a class="nav-link-smooth text-on-surface-variant font-body-md text-body-md" href="#iletisim">İletişim</a>
            </nav>
            <button class="bg-[#8B7355] text-white px-[32px] py-[12px] rounded-[8px] text-[15px] font-semibold hover:bg-[#725e45] transition-all duration-200 ease-in-out"
                    onclick="window.location.href='login.php'">
                Giriş Yap
            </button>
        </div>
    </header>

    <main>
        <!-- 1. ANASAYFA BÖLÜMÜ -->
        <section id="anasayfa" class="min-h-screen relative overflow-hidden bg-cover bg-right-top bg-no-repeat" 
                 style="background-image: url('assets/images/home2.jpeg'); background-size: cover; background-position: right center;">
            
            <div class="max-w-[1280px] mx-auto px-gutter py-xxl min-h-screen flex items-center">
                <div class="max-w-xl">
                    <h1 class="text-6xl md:text-7xl font-bold mb-lg leading-tight">
                        <span class="text-[#2D2419]">Sahiplen.</span><br>
                        <span class="text-[#8B6F47]">Satın Alma.</span>
                    </h1>
                    <button class="border-2 border-[#2D2419] text-[#2D2419] px-xl py-md rounded-sm font-button text-button uppercase hover:bg-[#2D2419] hover:text-white transition-all cursor-pointer active:scale-95"
                            onclick="document.getElementById('sahiplen').scrollIntoView({behavior: 'smooth'})">
                        BİR HAYATI DEĞİŞTİR
                    </button>
                </div>
            </div>
        </section>

        <!-- 2. SAHİPLEN BÖLÜMÜ -->
        <section id="sahiplen" class="py-xxl bg-background">
            <div class="max-w-[1280px] mx-auto px-gutter">
                <div class="text-center mb-xxl">
                    <h2 class="font-headline-xl text-headline-xl text-on-surface mb-sm">Sahiplenmeyi Bekleyen Dostlarımız</h2>
                    <p class="font-body-lg text-body-lg text-on-surface-variant">
                        Yeni bir ailenin sıcaklığını bekleyen sevgi dolu dostlarımızla tanışın
                    </p>
                </div>

                <?php if (!empty($pets)): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-lg">
                        <?php foreach ($pets as $pet): ?>
                            <div class="bg-white rounded-xl overflow-hidden soft-shadow hover:shadow-2xl transition-shadow duration-300">
                                <div class="relative aspect-[4/3] overflow-hidden bg-surface-container">
                                    <span class="absolute top-md left-md z-10 bg-secondary-container text-on-secondary-container px-md py-xs rounded-full font-label-md text-label-md">
                                        <?php echo strtoupper(htmlspecialchars($pet['type'] ?? 'HAYVAN')); ?>
                                    </span>
                                    
                                    <?php if (!empty($pet['image']) && file_exists('assets/images/' . $pet['image'])): ?>
                                        <img src="assets/images/<?php echo htmlspecialchars($pet['image']); ?>" 
                                             alt="<?php echo htmlspecialchars($pet['name']); ?>"
                                             class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-8xl">
                                            <?php echo ($pet['type'] == 'Kedi') ? '🐱' : '🐶'; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="p-lg">
                                    <h3 class="font-headline-lg text-[24px] text-primary mb-xs">
                                        <?php echo htmlspecialchars($pet['name']); ?>
                                    </h3>
                                    <p class="font-body-md text-on-surface-variant mb-md">
                                        <?php echo htmlspecialchars($pet['breed'] ?? $pet['type']); ?> • 
                                        <?php echo htmlspecialchars($pet['age']); ?> Yaşında
                                    </p>
                                    
                                    <button class="w-full bg-primary text-on-primary py-md rounded-lg font-button text-button uppercase hover:opacity-90 transition-all cursor-pointer active:scale-95"
                                            onclick="window.location.href='pet-detail.php?id=<?php echo $pet['id']; ?>'">
                                        DETAYLARI GÖR
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="text-center mt-xl">
                        <button class="border-2 border-primary text-primary px-xxl py-md rounded-lg font-button text-button uppercase hover:bg-primary hover:text-on-primary transition-all cursor-pointer active:scale-95"
                                onclick="window.location.href='sahiplen.php'">
                            TÜM HAYVANLARI GÖR
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- 3. HAKKIMIZDA BÖLÜMÜ -->
        <section id="hakkimizda" class="py-xxl bg-surface-container-low">
            <div class="max-w-[1280px] mx-auto px-gutter">
                <!-- Bizim Hikayemiz -->
                <div class="text-center mb-xxl">
                    <h2 class="font-headline-xl text-headline-xl text-on-surface mb-sm">Bizim Hikayemiz</h2>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
                        PatiKapısı olarak misyonumuz, her evcil hayvanın sevgi dolu bir yuvaya kavuşmasını sağlamaktır. 
                        Doğru eşleşmeleri oluşturarak ömür boyu sürecek dostlukların kapısını aralıyoruz.
                    </p>
                </div>

                <!-- 4 Adımlı Süreç -->
                <div class="mb-xxl">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-lg relative">
                        <div class="hidden md:block absolute top-1/4 left-[12.5%] right-[12.5%] h-px border-t-2 border-dashed border-outline-variant -z-10"></div>
                        
                        <div class="flex flex-col items-center text-center p-md">
                            <div class="w-16 h-16 rounded-full bg-primary text-on-primary flex items-center justify-center mb-md soft-shadow">
                                <span class="material-symbols-outlined text-[32px]">description</span>
                            </div>
                            <h4 class="font-headline-lg text-[24px] text-primary mb-xs">1. Başvuru</h4>
                            <p class="font-body-md text-on-surface-variant">
                                Yaşam tarzınız, eviniz ve aradığınız dost hakkında bize bilgi verin.
                            </p>
                        </div>
                        
                        <div class="flex flex-col items-center text-center p-md">
                            <div class="w-16 h-16 rounded-full bg-primary text-on-primary flex items-center justify-center mb-md soft-shadow">
                                <span class="material-symbols-outlined text-[32px]">forum</span>
                            </div>
                            <h4 class="font-headline-lg text-[24px] text-primary mb-xs">2. Mülakat</h4>
                            <p class="font-body-md text-on-surface-variant">
                                Sizin için en iyi eşleşmeyi sağlamak amacıyla uzmanlarımızla samimi bir görüşme.
                            </p>
                        </div>
                        
                        <div class="flex flex-col items-center text-center p-md">
                            <div class="w-16 h-16 rounded-full bg-primary text-on-primary flex items-center justify-center mb-md soft-shadow">
                                <span class="material-symbols-outlined text-[32px]">home_pin</span>
                            </div>
                            <h4 class="font-headline-lg text-[24px] text-primary mb-xs">3. Ev Ziyareti</h4>
                            <p class="font-body-md text-on-surface-variant">
                                Evinizi evcil hayvana hazır hale getirmenize ve yeni dostunuzun gelişine hazırlanmanıza yardımcı olacağız.
                            </p>
                        </div>
                        
                        <div class="flex flex-col items-center text-center p-md">
                            <div class="w-16 h-16 rounded-full bg-primary text-on-primary flex items-center justify-center mb-md soft-shadow">
                                <span class="material-symbols-outlined text-[32px]">celebration</span>
                            </div>
                            <h4 class="font-headline-lg text-[24px] text-primary mb-xs">4. Yuvaya Merhaba</h4>
                            <p class="font-body-md text-on-surface-variant">
                                Belgeleri imzalayın ve yeni hayatınıza başlayın. Her zaman bir telefon uzağınızdayız!
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Hazırlık Her Şeydir -->
                <div class="bg-white p-xl rounded-xl soft-shadow mb-xxl">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-xl items-center">
                        <div class="grid grid-cols-2 gap-md">
                            <div class="bg-surface-container-low p-lg rounded-xl">
                                <span class="material-symbols-outlined text-primary mb-sm" style="font-variation-settings: 'FILL' 1;">bed</span>
                                <h5 class="font-label-md text-label-md text-on-surface mb-xs">Sessiz Alan</h5>
                                <p class="text-sm text-on-surface-variant">
                                    Evcil hayvanınızın rahatsız edilmeden dinlenebileceği güvenli bir bölge oluşturun.
                                </p>
                            </div>
                            <div class="bg-surface-container-low p-lg rounded-xl">
                                <span class="material-symbols-outlined text-primary mb-sm" style="font-variation-settings: 'FILL' 1;">restaurant</span>
                                <h5 class="font-label-md text-label-md text-on-surface mb-xs">Düzenli Öğünler</h5>
                                <p class="text-sm text-on-surface-variant">
                                    Güven ve emniyet duygusu oluşturmak için beslenme saatlerini tutarlı tutun.
                                </p>
                            </div>
                            <div class="bg-surface-container-low p-lg rounded-xl">
                                <span class="material-symbols-outlined text-primary mb-sm" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
                                <h5 class="font-label-md text-label-md text-on-surface mb-xs">Önce Sabır</h5>
                                <p class="text-sm text-on-surface-variant">
                                    Kendi hızında keşfetmesine izin verin. Alışma süreci zaman alır.
                                </p>
                            </div>
                            <div class="bg-surface-container-low p-lg rounded-xl">
                                <span class="material-symbols-outlined text-primary mb-sm" style="font-variation-settings: 'FILL' 1;">calendar_today</span>
                                <h5 class="font-label-md text-label-md text-on-surface mb-xs">3-3-3 Kuralı</h5>
                                <p class="text-sm text-on-surface-variant">
                                    Uyum aşamalarını anlayın: 3 gün, 3 hafta, 3 ay.
                                </p>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-headline-xl text-headline-xl text-primary mb-md">Hazırlık Her Şeydir</h3>
                            <p class="font-body-lg text-body-lg text-on-surface-variant mb-lg">
                                Bir evcil hayvanı eve getirmek heyecan vericidir, ancak sorunsuz bir geçiş sakin bir yaklaşım 
                                gerektirir. Bu uzman onaylı ipuçları, hem sizin hem de yeni tüylü aile üyeniz için stresi en 
                                aza indirmeye yardımcı olur.
                            </p>
                            <ul class="space-y-sm">
                                <li class="flex items-start gap-sm">
                                    <span class="material-symbols-outlined text-primary">check_circle</span>
                                    <span class="font-body-md">Gelmeden önce kaliteli mama ve temel malzemeleri stoklayın.</span>
                                </li>
                                <li class="flex items-start gap-sm">
                                    <span class="material-symbols-outlined text-primary">check_circle</span>
                                    <span class="font-body-md">İlk hafta içinde bir veteriner kontrolü randevusu planlayın.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- SSS -->
                <div>
                    <div class="text-center mb-xl">
                        <h3 class="font-headline-xl text-headline-xl text-on-surface">Sıkça Sorulan Sorular</h3>
                        <p class="font-body-md text-on-surface-variant mt-sm">Sahiplenme sürecimiz hakkında bilmeniz gereken her şey.</p>
                    </div>
                    <div class="max-w-[800px] mx-auto space-y-md">
                        <div class="bg-white border border-outline-variant rounded-xl overflow-hidden">
                            <button class="w-full flex items-center justify-between p-lg text-left hover:bg-surface-container-low transition-colors"
                                    onclick="toggleFAQ(this)">
                                <span class="font-label-md text-label-md text-on-surface">Sahiplenme süreci ne kadar sürer?</span>
                                <span class="material-symbols-outlined text-outline faq-icon">expand_more</span>
                            </button>
                            <div class="px-lg pb-lg faq-content">
                                <p class="text-on-surface-variant font-body-md">
                                    Süreç ortalama 7 ila 14 gün sürer. Bu, mükemmel bir eşleşme sağlamak için başvuruları düzgün 
                                    bir şekilde incelememize ve ev ziyaretini koordine etmemize olanak tanır.
                                </p>
                            </div>
                        </div>
                        
                        <div class="bg-white border border-outline-variant rounded-xl overflow-hidden">
                            <button class="w-full flex items-center justify-between p-lg text-left hover:bg-surface-container-low transition-colors"
                                    onclick="toggleFAQ(this)">
                                <span class="font-label-md text-label-md text-on-surface">Sahiplenme ücreti var mı?</span>
                                <span class="material-symbols-outlined text-outline faq-icon">expand_more</span>
                            </button>
                            <div class="hidden px-lg pb-lg faq-content">
                                <p class="text-on-surface-variant font-body-md">
                                    Evet, ücretlerimiz aşıları, kısırlaştırma operasyonunu ve ilk sağlık taramalarını kapsar. 
                                    Bu, daha fazla evcil hayvana yardım etme misyonumuza katkıda bulunur.
                                </p>
                            </div>
                        </div>
                        
                        <div class="bg-white border border-outline-variant rounded-xl overflow-hidden">
                            <button class="w-full flex items-center justify-between p-lg text-left hover:bg-surface-container-low transition-colors"
                                    onclick="toggleFAQ(this)">
                                <span class="font-label-md text-label-md text-on-surface">Sahiplenmeden sonra destek alabilir miyim?</span>
                                <span class="material-symbols-outlined text-outline faq-icon">expand_more</span>
                            </button>
                            <div class="hidden px-lg pb-lg faq-content">
                                <p class="text-on-surface-variant font-body-md">
                                    Evet, sahiplendikten sonra da sizinle iletişim halinde kalıyoruz. Veteriner tavsiyeleri, 
                                    eğitim ipuçları ve uyum süreciyle ilgili her konuda destek sağlıyoruz. Ayrıca acil 
                                    durumlarda 7/24 ulaşabileceğiniz bir danışma hattımız bulunmaktadır.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. İLETİŞİM BÖLÜMÜ -->
        <section id="iletisim" class="py-xxl bg-background">
            <div class="max-w-[1280px] mx-auto px-gutter">
                <div class="text-center mb-xxl">
                    <h2 class="font-headline-xl text-headline-xl text-on-surface mb-sm">Bizimle İletişime Geçin</h2>
                    <p class="font-body-lg text-body-lg text-on-surface-variant">
                        Sorularınız mı var? Size yardımcı olmaktan mutluluk duyarız.
                    </p>
                </div>

                <div class="max-w-2xl mx-auto bg-white p-xl rounded-xl soft-shadow">
                    <form class="space-y-lg">
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface mb-xs">İsim</label>
                            <input type="text" class="w-full px-md py-md border border-outline-variant rounded-lg focus:border-primary focus:outline-none transition-colors">
                        </div>
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface mb-xs">E-posta</label>
                            <input type="email" class="w-full px-md py-md border border-outline-variant rounded-lg focus:border-primary focus:outline-none transition-colors">
                        </div>
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface mb-xs">Mesaj</label>
                            <textarea rows="5" class="w-full px-md py-md border border-outline-variant rounded-lg focus:border-primary focus:outline-none transition-colors"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-primary text-on-primary py-md rounded-lg font-button text-button uppercase hover:opacity-90 transition-all cursor-pointer active:scale-95">
                            GÖNDER
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <script>
        // Header arka plan değiştirme (scroll'da)
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.remove('bg-transparent');
                header.classList.add('bg-background', 'shadow-sm');
            } else {
                header.classList.remove('bg-background', 'shadow-sm');
                header.classList.add('bg-transparent');
            }
        });

        // FAQ toggle fonksiyonu
        function toggleFAQ(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('.faq-icon');
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.textContent = 'expand_less';
            } else {
                content.classList.add('hidden');
                icon.textContent = 'expand_more';
            }
        }

        // Smooth scrolling için
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

<?php include 'includes/footer.php'; ?>
