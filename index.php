<?php
// Sayfa başlığını tanımla
$page_title = 'Anasayfa';
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
    <!-- Header (Transparent, overlaying the hero image) -->
    <header class="bg-transparent absolute top-0 left-0 right-0 z-50">
        <div class="flex justify-between items-center max-w-[1280px] mx-auto px-gutter py-md">
            <div class="font-headline-lg text-headline-lg text-primary">
                <a href="index.php">PatiKapısı</a>
            </div>
            <nav class="hidden md:flex gap-xl items-center">
                <a class="nav-link-smooth text-on-surface-variant font-body-md text-body-md" href="index.php">Anasayfa</a>
                <a class="nav-link-smooth text-on-surface-variant font-body-md text-body-md" href="sahiplen.php">Sahiplen</a>
                <a class="nav-link-smooth text-on-surface-variant font-body-md text-body-md" href="hakkimizda.php">Hakkımızda</a>
                <a class="nav-link-smooth text-on-surface-variant font-body-md text-body-md" href="iletisim.php">İletişim</a>
            </nav>
            <button class="bg-[#8B7355] text-white px-[32px] py-[12px] rounded-[8px] text-[15px] font-semibold hover:bg-[#725e45] transition-all duration-200 ease-in-out"
                    onclick="window.location.href='login.php'">
                Giriş Yap
            </button>
        </div>
    </header>

    <main>
        <!-- Hero Section with Full Background Image -->
        <section class="min-h-screen relative overflow-hidden bg-cover bg-right-top bg-no-repeat" 
                 style="background-image: url('assets/images/home2.jpeg'); background-size: cover; background-position: right center;">
            
            <div class="max-w-[1280px] mx-auto px-gutter py-xxl min-h-screen flex items-center">
                <div class="max-w-xl">
                    <h1 class="text-6xl md:text-7xl font-bold mb-lg leading-tight">
                        <span class="text-[#2D2419]">Sahiplen.</span><br>
                        <span class="text-[#8B6F47]">Satın Alma.</span>
                    </h1>
                    <button class="border-2 border-[#2D2419] text-[#2D2419] px-xl py-md rounded-sm font-button text-button uppercase hover:bg-[#2D2419] hover:text-white transition-all cursor-pointer active:scale-95"
                            onclick="window.location.href='sahiplen.php'">
                        BİR HAYATI DEĞİŞTİR
                    </button>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
