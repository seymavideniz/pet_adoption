<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Evcil hayvan sahiplendirme platformu - Sevgi dolu dostlarınızla buluşun">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Evcil Hayvan Sahiplendirme</title>
    
    <!-- CSS Dosyaları -->
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/layout.css">
    <link rel="stylesheet" href="assets/css/components.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="index.php">
                        <span class="logo-text">PatiKapısı</span>
                    </a>
                </div>
                
                <nav class="main-nav">
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="index.php#home" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' && !isset($_GET['section']) ? 'active' : ''; ?>">
                                Anasayfa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php#sahiplen" class="nav-link">
                                Sahiplen
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php#hakkimizda" class="nav-link">
                                Hakkımızda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php#iletisim" class="nav-link">
                                İletişim
                            </a>
                        </li>
                    </ul>
                </nav>
                
                <div class="header-actions">
                    <a href="login.php" class="btn btn-login">Giriş Yap</a>
                </div>
            </div>
        </div>
    </header>
