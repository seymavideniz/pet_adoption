<?php
/**
 * Header Component
 * Tüm sayfalarda kullanılan ortak başlık bölümü
 * Session kontrolü ve kullanıcı bilgilerini yönetir
 */

// Session kontrolü - Eğer session başlatılmamışsa başlat
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kullanıcı giriş durumunu kontrol et
$is_logged_in = isset($_SESSION['user_id']);
$user_name = $_SESSION['full_name'] ?? $_SESSION['username'] ?? 'Kullanıcı';
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Hangi dizinde olduğumuzu belirle (root mu pages/ içinde mi)
$in_pages = (basename(dirname($_SERVER['SCRIPT_FILENAME'])) === 'pages');
$path_prefix = $in_pages ? '../' : '';
$pages_prefix = $in_pages ? '' : 'pages/';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Evcil hayvan sahiplendirme platformu - Sevgi dolu dostlarınızla buluşun">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Evcil Hayvan Sahiplendirme</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Google Fonts: Manrope & Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <!-- Tailwind Configuration -->
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
                    }
                }
            }
        }
    </script>
    
    <!-- CSS Dosyaları -->
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>assets/css/layout.css">
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>assets/css/components.css">
    
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="<?php echo $path_prefix; ?>index.php">
                        <span class="logo-text">PatiKapısı</span>
                    </a>
                </div>
                
                <nav class="main-nav">
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="<?php echo $path_prefix; ?>index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' && !isset($_GET['section']) ? 'active' : ''; ?>">
                                Anasayfa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $pages_prefix; ?>sahiplen.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'sahiplen.php' ? 'active' : ''; ?>">
                                Sahiplen
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $pages_prefix; ?>hakkimizda.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'hakkimizda.php' ? 'active' : ''; ?>">
                                Hakkımızda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $pages_prefix; ?>iletisim.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'iletisim.php' ? 'active' : ''; ?>">
                                İletişim
                            </a>
                        </li>
                        <?php if ($is_logged_in && !$is_admin): ?>
                            <li class="nav-item">
                                <a href="<?php echo $pages_prefix; ?>my-favorites.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'my-favorites.php' ? 'active' : ''; ?>">
                                    Patili Dostlarım
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
                
                <div class="header-actions">
                    <?php if ($is_logged_in): ?>
                        <!-- Kullanıcı giriş yapmış -->
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <?php if ($is_admin): ?>
                                <a href="<?php echo $path_prefix; ?>admin/dashboard.php" style="color: #705738; text-decoration: none; font-weight: 600;">
                                    Admin Paneli
                                </a>
                            <?php endif; ?>
                            <a href="<?php echo $pages_prefix; ?>logout.php" class="btn btn-login">
                                Çıkış Yap
                            </a>
                        </div>
                    <?php else: ?>
                        <!-- Kullanıcı giriş yapmamış -->
                        <a href="<?php echo $pages_prefix; ?>login.php" class="btn btn-login">Giriş Yap</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
