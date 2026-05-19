<?php
// Sayfa başlığını tanımla
$page_title = 'Hakkımızda';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Evcil Hayvan Sahiplendirme</title>
    
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
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .soft-shadow {
            box-shadow: 0 20px 40px -20px rgba(112, 87, 56, 0.08);
        }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md">
    <header class="bg-background sticky top-0 z-50">
        <div class="flex justify-between items-center max-w-[1280px] mx-auto px-gutter py-md">
            <div class="font-headline-lg text-headline-lg text-primary">
                <a href="../index.php">PatiKapısı</a>
            </div>
            <nav class="hidden md:flex gap-xl items-center">
                <a class="text-on-surface-variant hover:text-primary transition-colors duration-200 font-body-md text-body-md" href="../index.php">Anasayfa</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors duration-200 font-body-md text-body-md" href="sahiplen.php">Sahiplen</a>
                <a class="text-primary font-bold border-b-2 border-primary pb-1 font-body-md text-body-md" href="hakkimizda.php">Hakkımızda</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors duration-200 font-body-md text-body-md" href="iletisim.php">İletişim</a>
            </nav>
            <button class="bg-primary text-on-primary px-lg py-sm rounded-lg font-button text-button cursor-pointer active:scale-95 transition-transform"
                    onclick="window.location.href='login.php'">
                GİRİŞ YAP
            </button>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="relative bg-surface-container-low overflow-hidden">
            <div class="max-w-[1280px] mx-auto px-gutter py-xxl flex flex-col md:flex-row items-center gap-xl">
                <div class="md:w-1/2">
                    <h1 class="font-display-lg text-display-lg text-primary mb-md">Bizim Hikayemiz</h1>
                    <p class="font-body-lg text-body-lg text-on-surface-variant mb-lg max-w-lg">
                        PatiKapısı olarak misyonumuz, her evcil hayvanın sevgi dolu bir yuvaya kavuşmasını sağlamaktır. 
                        Doğru eşleşmeleri oluşturarak ömür boyu sürecek dostlukların kapısını aralıyoruz. Profesyonel 
                        rehberliğimizle, hem hayvanlar hem de yeni aileleri için bu yolculuğu güvenli ve mutlu kılıyoruz.
                    </p>
                    <div class="flex gap-md">
                        <button class="border-2 border-primary text-primary px-xl py-md rounded-lg font-button text-button uppercase hover:bg-primary hover:text-on-primary transition-all"
                                onclick="window.location.href='sahiplen.php'">
                            YOLCULUĞA BAŞLA
                        </button>
                    </div>
                </div>
                <div class="md:w-1/2 relative h-[500px] w-full">
                    <div class="absolute inset-0 bg-primary-fixed-dim rounded-full opacity-10 blur-3xl -z-10"></div>
                    <img alt="PatiKapısı Hakkımızda Görseli" 
                         class="w-full h-full object-cover rounded-xl soft-shadow" 
                         src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?w=800&h=500&fit=crop"/>
                </div>
            </div>
        </section>

        <!-- 4 Adımlı Yol -->
        <section class="py-xxl max-w-[1280px] mx-auto px-gutter">
            <div class="text-center mb-xxl">
                <h2 class="font-headline-xl text-headline-xl text-on-surface mb-sm">Yuvaya Giden 4 Adımlı Yol</h2>
                <p class="font-body-lg text-body-lg text-on-surface-variant">Her adımda net, profesyonel ve yanınızdayız.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-lg relative">
                <div class="hidden md:block absolute top-1/4 left-[12.5%] right-[12.5%] h-px border-t-2 border-dashed border-outline-variant -z-10"></div>
                
                <div class="flex flex-col items-center text-center p-md">
                    <div class="w-16 h-16 rounded-full bg-primary text-on-primary flex items-center justify-center mb-md soft-shadow">
                        <span class="material-symbols-outlined text-[32px]">description</span>
                    </div>
                    <h3 class="font-headline-lg text-[24px] text-primary mb-xs">1. Başvuru</h3>
                    <p class="font-body-md text-on-surface-variant">
                        Yaşam tarzınız, eviniz ve aradığınız dost hakkında bize bilgi verin.
                    </p>
                </div>
                
                <div class="flex flex-col items-center text-center p-md">
                    <div class="w-16 h-16 rounded-full bg-primary text-on-primary flex items-center justify-center mb-md soft-shadow">
                        <span class="material-symbols-outlined text-[32px]">forum</span>
                    </div>
                    <h3 class="font-headline-lg text-[24px] text-primary mb-xs">2. Mülakat</h3>
                    <p class="font-body-md text-on-surface-variant">
                        Sizin için en iyi eşleşmeyi sağlamak amacıyla uzmanlarımızla samimi bir görüşme.
                    </p>
                </div>
                
                <div class="flex flex-col items-center text-center p-md">
                    <div class="w-16 h-16 rounded-full bg-primary text-on-primary flex items-center justify-center mb-md soft-shadow">
                        <span class="material-symbols-outlined text-[32px]">home_pin</span>
                    </div>
                    <h3 class="font-headline-lg text-[24px] text-primary mb-xs">3. Ev Ziyareti</h3>
                    <p class="font-body-md text-on-surface-variant">
                        Evinizi evcil hayvana hazır hale getirmenize ve yeni dostunuzun gelişine hazırlanmanıza yardımcı olacağız.
                    </p>
                </div>
                
                <div class="flex flex-col items-center text-center p-md">
                    <div class="w-16 h-16 rounded-full bg-primary text-on-primary flex items-center justify-center mb-md soft-shadow">
                        <span class="material-symbols-outlined text-[32px]">celebration</span>
                    </div>
                    <h3 class="font-headline-lg text-[24px] text-primary mb-xs">4. Yuvaya Merhaba</h3>
                    <p class="font-body-md text-on-surface-variant">
                        Belgeleri imzalayın ve yeni hayatınıza başlayın. Her zaman bir telefon uzağınızdayız!
                    </p>
                </div>
            </div>
        </section>

        <!-- Hazırlık İpuçları -->
        <section class="bg-surface-container py-xxl">
            <div class="max-w-[1280px] mx-auto px-gutter">
                <div class="flex flex-col md:flex-row gap-xl items-center">
                    <div class="md:w-1/2 order-2 md:order-1">
                        <div class="grid grid-cols-2 gap-md">
                            <div class="bg-white p-lg rounded-xl soft-shadow">
                                <span class="material-symbols-outlined text-primary mb-sm" style="font-variation-settings: 'FILL' 1;">bed</span>
                                <h4 class="font-label-md text-label-md text-on-surface mb-xs">Sessiz Alan</h4>
                                <p class="text-sm text-on-surface-variant">
                                    Evcil hayvanınızın rahatsız edilmeden dinlenebileceği güvenli bir bölge oluşturun.
                                </p>
                            </div>
                            <div class="bg-white p-lg rounded-xl soft-shadow mt-lg">
                                <span class="material-symbols-outlined text-primary mb-sm" style="font-variation-settings: 'FILL' 1;">restaurant</span>
                                <h4 class="font-label-md text-label-md text-on-surface mb-xs">Düzenli Öğünler</h4>
                                <p class="text-sm text-on-surface-variant">
                                    Güven ve emniyet duygusu oluşturmak için beslenme saatlerini tutarlı tutun.
                                </p>
                            </div>
                            <div class="bg-white p-lg rounded-xl soft-shadow">
                                <span class="material-symbols-outlined text-primary mb-sm" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
                                <h4 class="font-label-md text-label-md text-on-surface mb-xs">Önce Sabır</h4>
                                <p class="text-sm text-on-surface-variant">
                                    Kendi hızında keşfetmesine izin verin. Alışma süreci zaman alır.
                                </p>
                            </div>
                            <div class="bg-white p-lg rounded-xl soft-shadow mt-lg">
                                <span class="material-symbols-outlined text-primary mb-sm" style="font-variation-settings: 'FILL' 1;">calendar_today</span>
                                <h4 class="font-label-md text-label-md text-on-surface mb-xs">3-3-3 Kuralı</h4>
                                <p class="text-sm text-on-surface-variant">
                                    Uyum aşamalarını anlayın: 3 gün, 3 hafta, 3 ay.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-1/2 order-1 md:order-2">
                        <h2 class="font-headline-xl text-headline-xl text-primary mb-md">Hazırlık Her Şeydir</h2>
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
        </section>

        <!-- SSS -->
        <section class="py-xxl max-w-[800px] mx-auto px-gutter">
            <div class="text-center mb-xl">
                <h2 class="font-headline-xl text-headline-xl text-on-surface">Sıkça Sorulan Sorular</h2>
                <p class="font-body-md text-on-surface-variant mt-sm">Sahiplenme sürecimiz hakkında bilmeniz gereken her şey.</p>
            </div>
            <div class="space-y-md">
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
                        <span class="font-label-md text-label-md text-on-surface">İşler yolunda gitmezse evcil hayvanı geri getirebilir miyim?</span>
                        <span class="material-symbols-outlined text-outline faq-icon">expand_more</span>
                    </button>
                    <div class="hidden px-lg pb-lg faq-content">
                        <p class="text-on-surface-variant font-body-md">
                            Mükemmel eşleşmeler için çabalasak da, hayatın getirdiklerini anlıyoruz. Sahiplenme sonrası 
                            destek süresi sunuyoruz ve gerektiğinde bir hayvanı her zaman geri kabul ediyoruz.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        function toggleFAQ(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('.faq-icon');
            
            content.classList.toggle('hidden');
            
            if (content.classList.contains('hidden')) {
                icon.textContent = 'expand_more';
            } else {
                icon.textContent = 'expand_less';
            }
        }
    </script>
</body>
</html>
