<?php
// Sayfa başlığını tanımla
$page_title = 'Sahiplen';

// Veritabanı bağlantısını dahil et
require_once 'includes/db.php';

// Header dosyasını dahil et
require_once 'includes/header.php';

// Veritabanından evcil hayvanları çek
try {
    $stmt = $pdo->prepare("SELECT * FROM pets ORDER BY id DESC");
    $stmt->execute();
    $pets = $stmt->fetchAll();
} catch (PDOException $e) {
    $error_message = "Evcil hayvanlar yüklenirken bir hata oluştu: " . $e->getMessage();
    $pets = [];
}
?>

<main>
    <!-- Hero Section -->
    <section class="page-hero">
        <div class="container">
            <h1 class="page-hero-title">Yeni Dostunu Bul</h1>
            <p class="page-hero-subtitle">
                Sahiplenmeyi bekleyen binlerce minik dostumuz arasından size en uygun derin seçin ve yeni bir hayata kapı aralayın.
            </p>
        </div>
    </section>

    <div class="container">
        <?php if (isset($error_message)): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($pets)): ?>
            <div class="alert alert-info">
                <p style="text-align: center; margin: 0;">
                    Şu anda sahiplendirilmeyi bekleyen evcil hayvan bulunmamaktadır. 
                    Lütfen daha sonra tekrar kontrol edin.
                </p>
            </div>
        <?php else: ?>
            <!-- Evcil Hayvanlar Grid -->
            <section>
                <div class="grid grid-auto">
                    <?php foreach ($pets as $pet): ?>
                        <article class="card pet-card">
                            <div class="card-image">
                                <!-- Pet Type Badge -->
                                <span class="pet-type-badge">
                                    <?php 
                                    $type = $pet['type'] ?? 'Hayvan';
                                    $type = str_replace(['Ö', 'ö', 'Ü', 'ü', 'Ş', 'ş', 'İ', 'ı', 'Ğ', 'ğ', 'Ç', 'ç'], 
                                                      ['O', 'o', 'U', 'u', 'S', 's', 'I', 'i', 'G', 'g', 'C', 'c'], $type);
                                    echo strtoupper(htmlspecialchars($type));
                                    ?>
                                </span>
                                
                                <!-- Favorite Icon -->
                                <div class="favorite-icon" onclick="toggleFavorite(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </div>
                                
                                <!-- Pet Image -->
                                <?php if (!empty($pet['image']) && file_exists('assets/images/' . $pet['image'])): ?>
                                    <img src="assets/images/<?php echo htmlspecialchars($pet['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($pet['name'] ?? 'Evcil Hayvan'); ?>"
                                         style="width: 100%; height: 100%; object-fit: cover; object-position: center center;">
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
            
            <!-- Pagination -->
            <div class="pagination">
                <button class="pagination-btn" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
                <button class="pagination-btn active">1</button>
                <button class="pagination-btn">2</button>
                <button class="pagination-btn">3</button>
                <button class="pagination-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
function toggleFavorite(element) {
    element.classList.toggle('active');
}
</script>

<?php
// Footer dosyasını dahil et
require_once 'includes/footer.php';
?>
