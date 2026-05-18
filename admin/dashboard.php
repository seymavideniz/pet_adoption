<?php
require_once 'auth_check.php';
require_once '../includes/db.php';

$page_title = 'Dashboard';

// İstatistikleri al
try {
    // Toplam hayvan sayısı
    $total_pets = $pdo->query("SELECT COUNT(*) FROM pets")->fetchColumn();
    
    // Sahiplendirilebilir hayvan sayısı
    $available_pets = $pdo->query("SELECT COUNT(*) FROM pets WHERE status = 'Sahiplendirilebilir'")->fetchColumn();
    
    // Toplam kullanıcı sayısı
    $total_users = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'user'")->fetchColumn();
    
    // Son eklenen hayvanlar
    $recent_pets = $pdo->query("SELECT * FROM pets ORDER BY created_at DESC LIMIT 5")->fetchAll();
    
} catch (PDOException $e) {
    $error = "Veriler yüklenirken hata oluştu: " . $e->getMessage();
}

include 'includes/header.php';
?>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Toplam Hayvanlar -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Toplam Hayvanlar</p>
                <h3 class="text-3xl font-bold text-gray-800"><?php echo $total_pets ?? 0; ?></h3>
            </div>
            <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                <span class="material-symbols-outlined text-blue-600 text-3xl">pets</span>
            </div>
        </div>
    </div>
    
    <!-- Sahiplendirilebilir -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Sahiplendirilebilir</p>
                <h3 class="text-3xl font-bold text-gray-800"><?php echo $available_pets ?? 0; ?></h3>
            </div>
            <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                <span class="material-symbols-outlined text-green-600 text-3xl">check_circle</span>
            </div>
        </div>
    </div>
    
    <!-- Toplam Kullanıcılar -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Kayıtlı Kullanıcılar</p>
                <h3 class="text-3xl font-bold text-gray-800"><?php echo $total_users ?? 0; ?></h3>
            </div>
            <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                <span class="material-symbols-outlined text-purple-600 text-3xl">group</span>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <a href="add-pet.php" class="bg-gradient-to-br from-[#705738] to-[#8B6F4E] rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition-all transform hover:-translate-y-1">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">add_circle</span>
            </div>
            <div>
                <h3 class="text-xl font-bold">Yeni Hayvan Ekle</h3>
                <p class="text-sm opacity-90">Sahiplenme için hayvan ekleyin</p>
            </div>
        </div>
    </a>
    
    <a href="manage-pets.php" class="bg-gradient-to-br from-[#E3C19A] to-[#D7C3B0] rounded-xl shadow-lg p-6 text-[#2D2419] hover:shadow-xl transition-all transform hover:-translate-y-1">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-white/40 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">settings</span>
            </div>
            <div>
                <h3 class="text-xl font-bold">Hayvanları Yönet</h3>
                <p class="text-sm opacity-90">Düzenle, sil veya güncelle</p>
            </div>
        </div>
    </a>
</div>

<!-- Recent Pets -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-xl font-bold text-gray-800">Son Eklenen Hayvanlar</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Resim</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">İsim</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tür</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Yaş</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Durum</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">İşlemler</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if (!empty($recent_pets)): ?>
                    <?php foreach ($recent_pets as $pet): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <?php if (!empty($pet['image']) && file_exists('../assets/images/' . $pet['image'])): ?>
                                    <img src="../assets/images/<?php echo htmlspecialchars($pet['image']); ?>" alt="<?php echo htmlspecialchars($pet['name']); ?>" class="w-12 h-12 rounded-lg object-cover">
                                <?php else: ?>
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center text-2xl">
                                        <?php echo ($pet['type'] == 'Kedi') ? '🐱' : '🐶'; ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-800"><?php echo htmlspecialchars($pet['name']); ?></td>
                            <td class="px-6 py-4 text-gray-600"><?php echo htmlspecialchars($pet['type']); ?></td>
                            <td class="px-6 py-4 text-gray-600"><?php echo htmlspecialchars($pet['age']); ?> yaş</td>
                            <td class="px-6 py-4">
                                <?php if ($pet['status'] == 'Sahiplendirilebilir'): ?>
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Uygun</span>
                                <?php else: ?>
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold"><?php echo htmlspecialchars($pet['status']); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <a href="manage-pets.php?edit=<?php echo $pet['id']; ?>" class="text-blue-600 hover:text-blue-800 mr-3">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            Henüz hayvan eklenmemiş.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
