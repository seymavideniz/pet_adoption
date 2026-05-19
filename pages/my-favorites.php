<?php
// Session başlat
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Giriş kontrolü
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$page_title = 'Patili Dostlarım';

// Veritabanı bağlantısı
require_once '../includes/db.php';

// Favoriden çıkarma işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_favorite'])) {
    $pet_id = intval($_POST['pet_id']);
    try {
        $stmt = $pdo->prepare("DELETE FROM favorites WHERE user_id = ? AND pet_id = ?");
        $stmt->execute([$user_id, $pet_id]);
        // Sayfayı yenile
        header('Location: my-favorites.php');
        exit();
    } catch (PDOException $e) {
        $error_message = "Favoriden çıkarılırken bir hata oluştu.";
    }
}

// Favori hayvanları getir
try {
    $stmt = $pdo->prepare("
        SELECT p.* 
        FROM favorites f 
        INNER JOIN pets p ON f.pet_id = p.id 
        WHERE f.user_id = ? 
        ORDER BY f.created_at DESC
    ");
    $stmt->execute([$user_id]);
    $favorites = $stmt->fetchAll();
} catch (PDOException $e) {
    $error_message = "Favoriler yüklenirken bir hata oluştu: " . $e->getMessage();
    $favorites = [];
}

// Header dosyasını dahil et
require_once '../includes/header.php';
?>

<main>
    <!-- Hero Section -->
    <section class="page-hero">
        <div class="container">
            <h1 class="page-hero-title">Patili Dostlarım</h1>
        </div>
    </section>

    <div class="container">
        <?php if (isset($error_message)): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($favorites)): ?>
            <div class="alert alert-info">
                <p style="text-align: center; margin: 0;">
                    Henüz patili dostunuz yok. 
                    <a href="sahiplen.php" style="color: #705738; font-weight: 600; text-decoration: underline;">Hayvanları keşfedin</a> ve dostlarınıza ekleyin!
                </p>
            </div>
        <?php else: ?>
            <!-- Favori Hayvanlar Grid -->
            <section>
                <div class="grid grid-auto">
                    <?php foreach ($favorites as $pet): ?>
                        <article class="card pet-card">
                            <div class="card-image">
                                <!-- Pet Type Badge -->
                                <span class="pet-type-badge">
                                    <?php 
                                    $type = $pet['type'] ?? 'HAYVAN';
                                    $type = str_replace(['Ö', 'ö', 'Ü', 'ü', 'Ş', 'ş', 'İ', 'ı', 'Ğ', 'ğ', 'Ç', 'ç'], 
                                                      ['O', 'o', 'U', 'u', 'S', 's', 'I', 'i', 'G', 'g', 'C', 'c'], $type);
                                    echo strtoupper(htmlspecialchars($type));
                                    ?>
                                </span>
                                
                                <!-- Favorite Icon (Already Favorited - Clickable to Remove) -->
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="remove_favorite" value="1">
                                    <input type="hidden" name="pet_id" value="<?php echo $pet['id']; ?>">
                                    <button type="submit" class="favorite-icon active" style="border: none; background: transparent; padding: 0; cursor: pointer;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                    </button>
                                </form>
                                
                                <!-- Pet Image -->
                                <?php if (!empty($pet['image']) && file_exists('../assets/images/' . $pet['image'])): ?>
                                    <img src="../assets/images/<?php echo htmlspecialchars($pet['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($pet['name'] ?? 'Evcil Hayvan'); ?>"
                                         class="pet-image"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <?php else: ?>
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 5rem;">
                                        <?php 
                                        $petType = $pet['type'] ?? 'Köpek';
                                        echo ($petType == 'Kedi') ? '🐱' : '🐶'; 
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-content">
                                <h3 class="pet-name">
                                    <?php echo htmlspecialchars($pet['name'] ?? 'İsimsiz'); ?>
                                </h3>
                                
                                <p class="pet-info">
                                    <?php echo htmlspecialchars($pet['breed'] ?? $pet['type'] ?? 'Bilinmiyor'); ?> • <?php echo htmlspecialchars($pet['age'] ?? '0'); ?> Yaşında
                                </p>
                                
                                <!-- Pet Tags -->
                                <div class="pet-tags">
                                    <?php if (isset($pet['status']) && $pet['status'] == 'Sahiplendirilebilir'): ?>
                                        <span class="pet-tag">Uygun</span>
                                    <?php endif; ?>
                                    <?php if (!empty($pet['temperament'])): ?>
                                        <?php 
                                        $traits = explode(',', $pet['temperament']);
                                        foreach (array_slice($traits, 0, 3) as $trait): 
                                        ?>
                                            <span class="pet-tag"><?php echo htmlspecialchars(trim($trait)); ?></span>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span class="pet-tag">Sevimli</span>
                                        <span class="pet-tag">Oyuncu</span>
                                    <?php endif; ?>
                                </div>
                                
                                <a href="pet-detail.php?id=<?php echo $pet['id'] ?? ''; ?>" 
                                   class="btn-detail">
                                    Detayları Gör
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </div>
</main>

<?php
// Footer dosyasını dahil et
require_once '../includes/footer.php';
?>
