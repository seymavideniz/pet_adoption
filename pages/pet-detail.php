<?php
// Session başlat
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kullanıcı bilgilerini al
$is_logged_in = isset($_SESSION['user_id']);
$user_name = $_SESSION['full_name'] ?? $_SESSION['username'] ?? 'Kullanıcı';
$user_id = $_SESSION['user_id'] ?? null;
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Sayfa başlığını tanımla
$page_title = 'Hayvan Detayları';

// Veritabanı bağlantısını dahil et
require_once '../includes/db.php';

// URL'den pet id'yi al
$pet_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Favori ekleme/çıkarma işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['toggle_favorite']) && $is_logged_in) {
    try {
        // Favori var mı kontrol et
        $stmt = $pdo->prepare("SELECT id FROM favorites WHERE user_id = ? AND pet_id = ?");
        $stmt->execute([$user_id, $pet_id]);
        
        if ($stmt->rowCount() > 0) {
            // Favoriden çıkar
            $stmt = $pdo->prepare("DELETE FROM favorites WHERE user_id = ? AND pet_id = ?");
            $stmt->execute([$user_id, $pet_id]);
        } else {
            // Favoriye ekle
            $stmt = $pdo->prepare("INSERT INTO favorites (user_id, pet_id) VALUES (?, ?)");
            $stmt->execute([$user_id, $pet_id]);
        }
    } catch (PDOException $e) {
        // Hata mesajı
    }
}

// Veritabanından hayvan detaylarını çek
try {
    $stmt = $pdo->prepare("SELECT * FROM pets WHERE id = ?");
    $stmt->execute([$pet_id]);
    $pet = $stmt->fetch();
    
    if (!$pet) {
        header('Location: sahiplen.php');
        exit;
    }
    
    // Favori durumunu kontrol et
    $is_favorite = false;
    if ($is_logged_in) {
        $stmt = $pdo->prepare("SELECT id FROM favorites WHERE user_id = ? AND pet_id = ?");
        $stmt->execute([$user_id, $pet_id]);
        $is_favorite = $stmt->rowCount() > 0;
    }
} catch (PDOException $e) {
    $error_message = "Evcil hayvan detayları yüklenirken bir hata oluştu: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html class="light" lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pet['name']); ?> - Evcil Hayvan Sahiplendirme</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
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
        body { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .pet-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center;
        }
    </style>
</head>
<body class="bg-background text-on-background">
    <header class="bg-background dark:bg-background full-width top-0 sticky z-50">
        <div class="flex justify-between items-center max-w-[1280px] mx-auto px-gutter py-md">
            <div class="font-headline-lg text-headline-lg text-primary dark:text-primary-fixed">
                <a href="../index.php">PatiKapısı</a>
            </div>
            <nav class="hidden md:flex gap-xl">
                <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors duration-200 cursor-pointer active:scale-95" href="../index.php">Anasayfa</a>
                <a class="font-body-md text-body-md text-primary font-bold border-b-2 border-primary pb-1 cursor-pointer active:scale-95" href="sahiplen.php">Sahiplen</a>
                <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors duration-200 cursor-pointer active:scale-95" href="#">Hakkımızda</a>
                <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors duration-200 cursor-pointer active:scale-95" href="iletisim.php">İletişim</a>
                <?php if ($is_logged_in && !$is_admin): ?>
                    <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors duration-200 cursor-pointer active:scale-95" href="my-favorites.php">Patili Dostlarım</a>
                <?php endif; ?>
            </nav>
            <?php if ($is_logged_in): ?>
                <!-- Kullanıcı giriş yapmış -->
                <div style="display: flex; align-items: center; gap: 16px;">
                    <?php if ($is_admin): ?>
                        <a href="../admin/dashboard.php" class="font-body-md text-primary font-semibold hover:opacity-80 transition-opacity">
                            Admin Paneli
                        </a>
                    <?php endif; ?>
                    <button class="font-button text-button uppercase bg-primary text-white px-lg py-sm rounded-lg hover:opacity-90 transition-all cursor-pointer active:scale-95" onclick="window.location.href='logout.php'">
                        ÇIKIŞ YAP
                    </button>
                </div>
            <?php else: ?>
                <!-- Kullanıcı giriş yapmamış -->
                <button class="font-button text-button uppercase bg-transparent border border-primary text-primary px-lg py-sm rounded-lg hover:bg-primary hover:text-white transition-all cursor-pointer active:scale-95" onclick="window.location.href='login.php'">
                    GİRİŞ YAP
                </button>
            <?php endif; ?>
        </div>
    </header>

    <?php if (isset($error_message)): ?>
        <div class="max-w-[1280px] mx-auto px-gutter py-xl">
            <div class="bg-error-container text-on-error-container p-lg rounded-xl">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        </div>
    <?php else: ?>
        <main class="max-w-[1280px] mx-auto px-gutter py-xl">
            <!-- Hero Section with Image and Basic Info -->
            <section class="grid grid-cols-1 md:grid-cols-12 gap-lg mb-xxl">
                <div class="md:col-span-7">
                    <div class="relative aspect-[4/3] overflow-hidden rounded-xl shadow-sm bg-surface-container">
                        <?php if (!empty($pet['image']) && file_exists('../assets/images/' . $pet['image'])): ?>
                            <img alt="<?php echo htmlspecialchars($pet['name']); ?>" 
                                 class="pet-image" 
                                 src="../assets/images/<?php echo htmlspecialchars($pet['image']); ?>"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-9xl">
                                <?php 
                                $petType = $pet['type'] ?? 'Köpek';
                                echo ($petType == 'Kedi') ? '🐱' : '🐶'; 
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="md:col-span-5 flex flex-col justify-center gap-md">
                    <div class="flex items-center gap-sm">
                        <span class="bg-secondary-container text-on-secondary-container px-md py-xs rounded-full font-label-md text-label-md">
                            <?php echo htmlspecialchars($pet['status'] ?? 'Sahiplenilmeyi Bekliyor'); ?>
                        </span>
                        <?php if ($is_logged_in): ?>
                            <form method="POST" id="favoriteForm" style="display: inline;">
                                <input type="hidden" name="toggle_favorite" value="1">
                                <button type="submit" class="bg-transparent border-0 p-0 cursor-pointer">
                                    <span class="material-symbols-outlined text-<?php echo $is_favorite ? 'red-500' : 'primary'; ?> cursor-pointer hover:scale-110 transition-transform" 
                                          style="font-variation-settings: 'FILL' <?php echo $is_favorite ? '1' : '0'; ?>; font-size: 32px;">
                                        favorite
                                    </span>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                    <h1 class="font-display-lg text-display-lg text-primary">
                        <?php echo htmlspecialchars($pet['name']); ?>
                    </h1>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-md">
                        <?php echo !empty($pet['description']) ? htmlspecialchars($pet['description']) : 'Ömür boyu sevgi ve güneşli yürüyüşler için sıcak bir yuva bekleyen nazik bir ruh.'; ?>
                    </p>
                    <div class="mt-lg">
                        <button class="w-full md:w-auto font-button text-button uppercase bg-primary text-on-primary px-xxl py-md rounded-lg shadow-sm hover:opacity-90 transition-all cursor-pointer active:scale-95"
                                onclick="window.location.href='iletisim.php?pet_id=<?php echo $pet['id']; ?>&pet_name=<?php echo urlencode($pet['name']); ?>'">
                            HEMEN SAHİPLEN
                        </button>
                    </div>
                </div>
            </section>

            <!-- Story and Attributes Section -->
            <section class="grid grid-cols-1 md:grid-cols-4 gap-lg mb-xxl">
                <div class="md:col-span-2 bg-white p-xl rounded-xl border border-outline-variant shadow-[0_20px_40px_rgba(112,87,56,0.04)]">
                    <h2 class="font-headline-lg text-headline-lg text-secondary mb-md">Onun Hikayesi</h2>
                    <div class="space-y-md font-body-md text-body-md text-on-surface-variant">
                        <?php 
                        if (!empty($pet['story'])) {
                            $story_paragraphs = explode("\n", $pet['story']);
                            foreach ($story_paragraphs as $paragraph) {
                                if (trim($paragraph) != '') {
                                    echo '<p>' . htmlspecialchars(trim($paragraph)) . '</p>';
                                }
                            }
                        } else {
                            echo '<p>' . htmlspecialchars($pet['name']) . ' yerel bir parkın yakınında dolaşırken bulundu, tüyleri biraz karışmış olsa da neşesinden hiçbir şey kaybetmemişti. Barınağa girdiği andan itibaren herkese sevgi ve ilgi gösterdi.</p>';
                            echo '<p>İnsanlarla vakit geçirmekten keyif alan, sakin yapılı bir dost. Huzurlu bir ev ortamına mükemmel uyum sağlayacak yumuşak bir kişiliğe sahip.</p>';
                        }
                        ?>
                    </div>
                </div>
                
                <div class="md:col-span-2 grid grid-cols-2 gap-lg">
                    <div class="bg-surface-container-low p-lg rounded-xl flex flex-col items-center justify-center text-center">
                        <span class="material-symbols-outlined text-primary mb-xs">calendar_today</span>
                        <span class="font-label-md text-label-md text-on-surface-variant uppercase">YAŞ</span>
                        <span class="font-headline-lg text-headline-lg text-secondary">
                            <?php echo htmlspecialchars($pet['age']); ?> Yaş
                        </span>
                    </div>
                    
                    <div class="bg-surface-container-low p-lg rounded-xl flex flex-col items-center justify-center text-center">
                        <span class="material-symbols-outlined text-primary mb-xs">
                            <?php echo ($pet['gender'] == 'Erkek') ? 'male' : 'female'; ?>
                        </span>
                        <span class="font-label-md text-label-md text-on-surface-variant uppercase">CİNSİYET</span>
                        <span class="font-headline-lg text-headline-lg text-secondary">
                            <?php echo htmlspecialchars($pet['gender'] ?? 'Dişi'); ?>
                        </span>
                    </div>
                    
                    <div class="bg-surface-container-low p-lg rounded-xl flex flex-col items-center justify-center text-center">
                        <span class="material-symbols-outlined text-primary mb-xs">monitor_weight</span>
                        <span class="font-label-md text-label-md text-on-surface-variant uppercase">AĞIRLIK</span>
                        <span class="font-headline-lg text-headline-lg text-secondary">
                            <?php echo htmlspecialchars($pet['size'] ?? '3kg'); ?>
                        </span>
                    </div>
                    
                    <div class="bg-surface-container-low p-lg rounded-xl flex flex-col items-center justify-center text-center">
                        <span class="material-symbols-outlined text-primary mb-xs">pets</span>
                        <span class="font-label-md text-label-md text-on-surface-variant uppercase">IRK</span>
                        <span class="font-headline-lg text-headline-lg text-secondary">
                            <?php echo htmlspecialchars($pet['breed'] ?? $pet['type']); ?>
                        </span>
                    </div>
                </div>
                
                <!-- Health and Care Section -->
                <div class="md:col-span-4 bg-surface-container p-xl rounded-xl flex flex-col md:flex-row items-center justify-between gap-lg">
                    <div>
                        <h3 class="font-headline-lg text-headline-lg text-secondary">Sağlık ve Bakım</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">
                            <?php echo htmlspecialchars($pet['name']); ?>'un tüm kontrolleri yapıldı ve bugün ailenize katılmaya hazır.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-md">
                        <div class="flex items-center gap-sm bg-white px-lg py-md rounded-full border border-outline-variant">
                            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">verified</span>
                            <span class="font-label-md text-label-md text-on-surface">Tam Aşılı</span>
                        </div>
                        <div class="flex items-center gap-sm bg-white px-lg py-md rounded-full border border-outline-variant">
                            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">content_cut</span>
                            <span class="font-label-md text-label-md text-on-surface">Kısırlaştırılmış</span>
                        </div>
                        <div class="flex items-center gap-sm bg-white px-lg py-md rounded-full border border-outline-variant">
                            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">radio_button_checked</span>
                            <span class="font-label-md text-label-md text-on-surface">Mikroçipli</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Photo Gallery -->
            <section class="mb-xxl">
                <h2 class="font-headline-lg text-headline-lg text-secondary mb-xl text-center">
                    <?php echo htmlspecialchars($pet['name']); ?>'tan Kareler
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-lg">
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                        <div class="aspect-square overflow-hidden rounded-xl bg-surface-container-high">
                            <?php if (!empty($pet['image']) && file_exists('../assets/images/' . $pet['image'])): ?>
                                <img alt="<?php echo htmlspecialchars($pet['name']); ?> - Fotoğraf <?php echo $i; ?>" 
                                     class="pet-image hover:scale-105 cursor-pointer" 
                                     style="transition: transform 0.5s;" 
                                     src="../assets/images/<?php echo htmlspecialchars($pet['image']); ?>">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-7xl hover:scale-105 transition-transform duration-500">
                                    <?php 
                                    $petType = $pet['type'] ?? 'Köpek';
                                    echo ($petType == 'Kedi') ? '🐱' : '🐶'; 
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endfor; ?>
                </div>
            </section>

            <!-- Call to Action Section -->
            <section class="bg-primary-container text-on-primary-container p-xxl rounded-xl text-center">
                <h2 class="font-headline-xl text-headline-xl mb-md">
                    <?php echo htmlspecialchars($pet['name']); ?> ile tanışmaya hazır mısınız?
                </h2>
                <p class="font-body-lg text-body-lg mb-xl max-w-2xl mx-auto opacity-90">
                    Ömür boyu sürecek bir dostluğa ilk adımı atın. Sahiplendirme sürecimiz, sizin ve <?php echo htmlspecialchars($pet['name']); ?> için en doğru eşleşmeyi sağlamak üzere tasarlanmıştır.
                </p>
                <div class="flex justify-center">
                    <button class="font-button text-button uppercase bg-white text-primary px-xxl py-md rounded-lg shadow-lg hover:bg-surface transition-all cursor-pointer active:scale-95"
                            onclick="window.location.href='iletisim.php?pet_id=<?php echo $pet['id']; ?>&pet_name=<?php echo urlencode($pet['name']); ?>'">
                        SAHİPLENME BAŞVURUSU
                    </button>
                </div>
            </section>
        </main>
    <?php endif; ?>

    <script>
        function toggleFavorite(element) {
            const currentFill = element.style.fontVariationSettings;
            if (currentFill.includes("'FILL' 1")) {
                element.style.fontVariationSettings = "'FILL' 0";
            } else {
                element.style.fontVariationSettings = "'FILL' 1";
            }
        }
    </script>
</body>
</html>
