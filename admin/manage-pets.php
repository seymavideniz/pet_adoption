<?php
require_once 'auth_check.php';
require_once '../includes/db.php';

$page_title = 'Hayvanları Yönet';
$success_message = '';
$error_message = '';

// Hayvan silme
if (isset($_GET['delete'])) {
    $pet_id = intval($_GET['delete']);
    try {
        // Önce resmi sil
        $stmt = $pdo->prepare("SELECT image FROM pets WHERE id = ?");
        $stmt->execute([$pet_id]);
        $pet = $stmt->fetch();
        
        if ($pet && !empty($pet['image'])) {
            $image_path = '../assets/images/' . $pet['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        
        // Hayvanı sil
        $stmt = $pdo->prepare("DELETE FROM pets WHERE id = ?");
        $stmt->execute([$pet_id]);
        $success_message = "Hayvan başarıyla silindi.";
    } catch (PDOException $e) {
        $error_message = "Silme hatası: " . $e->getMessage();
    }
}

// Düzenleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_id'])) {
    $edit_id = intval($_POST['edit_id']);
    $name = $_POST['name'] ?? '';
    $type = $_POST['type'] ?? '';
    $breed = $_POST['breed'] ?? '';
    $age = $_POST['age'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $size = $_POST['size'] ?? '';
    $color = $_POST['color'] ?? '';
    $temperament = $_POST['temperament'] ?? '';
    $health_status = $_POST['health_status'] ?? '';
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? 'Sahiplendirilebilir';
    
    // Yeni resim yüklendi mi?
    $image_name = $_POST['current_image'] ?? '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $file_type = $_FILES['image']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            // Eski resmi sil
            if (!empty($image_name)) {
                $old_image = '../assets/images/' . $image_name;
                if (file_exists($old_image)) {
                    unlink($old_image);
                }
            }
            
            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image_name = 'pet_' . time() . '_' . rand(1000, 9999) . '.' . $file_extension;
            $upload_path = '../assets/images/' . $image_name;
            move_uploaded_file($_FILES['image']['tmp_name'], $upload_path);
        }
    }
    
    try {
        $stmt = $pdo->prepare("UPDATE pets SET name=?, type=?, breed=?, age=?, gender=?, size=?, color=?, temperament=?, health_status=?, description=?, status=?, image=? WHERE id=?");
        $stmt->execute([$name, $type, $breed, $age, $gender, $size, $color, $temperament, $health_status, $description, $status, $image_name, $edit_id]);
        $success_message = "Hayvan bilgileri güncellendi!";
    } catch (PDOException $e) {
        $error_message = "Güncelleme hatası: " . $e->getMessage();
    }
}

// Tüm hayvanları getir
try {
    $search = $_GET['search'] ?? '';
    if (!empty($search)) {
        $stmt = $pdo->prepare("SELECT * FROM pets WHERE name LIKE ? OR type LIKE ? OR breed LIKE ? ORDER BY created_at DESC");
        $stmt->execute(["%$search%", "%$search%", "%$search%"]);
    } else {
        $stmt = $pdo->query("SELECT * FROM pets ORDER BY created_at DESC");
    }
    $pets = $stmt->fetchAll();
} catch (PDOException $e) {
    $error_message = "Hayvanlar yüklenirken hata oluştu: " . $e->getMessage();
    $pets = [];
}

// Düzenleme için hayvan seçildi mi?
$edit_pet = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    try {
        $stmt = $pdo->prepare("SELECT * FROM pets WHERE id = ?");
        $stmt->execute([$edit_id]);
        $edit_pet = $stmt->fetch();
    } catch (PDOException $e) {
        $error_message = "Hayvan bilgileri yüklenemedi.";
    }
}

include 'includes/header.php';
?>

<?php if ($success_message): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        <p><?php echo htmlspecialchars($success_message); ?></p>
    </div>
<?php endif; ?>

<?php if ($error_message): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
        <p><?php echo htmlspecialchars($error_message); ?></p>
    </div>
<?php endif; ?>

<?php if ($edit_pet): ?>
    <!-- Düzenleme Formu -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Hayvan Düzenle: <?php echo htmlspecialchars($edit_pet['name']); ?></h3>
        <form method="POST" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="edit_id" value="<?php echo $edit_pet['id']; ?>">
            <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($edit_pet['image']); ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Hayvan İsmi *</label>
                    <input type="text" name="name" required value="<?php echo htmlspecialchars($edit_pet['name']); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738]">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tür *</label>
                    <select name="type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738]">
                        <option value="Köpek" <?php echo $edit_pet['type'] == 'Köpek' ? 'selected' : ''; ?>>Köpek</option>
                        <option value="Kedi" <?php echo $edit_pet['type'] == 'Kedi' ? 'selected' : ''; ?>>Kedi</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cins</label>
                    <input type="text" name="breed" value="<?php echo htmlspecialchars($edit_pet['breed']); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738]">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Yaş *</label>
                    <input type="number" name="age" required value="<?php echo htmlspecialchars($edit_pet['age']); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738]">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cinsiyet *</label>
                    <select name="gender" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738]">
                        <option value="Erkek" <?php echo $edit_pet['gender'] == 'Erkek' ? 'selected' : ''; ?>>Erkek</option>
                        <option value="Dişi" <?php echo $edit_pet['gender'] == 'Dişi' ? 'selected' : ''; ?>>Dişi</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Büyüklük</label>
                    <select name="size" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738]">
                        <option value="Küçük" <?php echo $edit_pet['size'] == 'Küçük' ? 'selected' : ''; ?>>Küçük</option>
                        <option value="Orta" <?php echo $edit_pet['size'] == 'Orta' ? 'selected' : ''; ?>>Orta</option>
                        <option value="Büyük" <?php echo $edit_pet['size'] == 'Büyük' ? 'selected' : ''; ?>>Büyük</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Renk</label>
                    <input type="text" name="color" value="<?php echo htmlspecialchars($edit_pet['color']); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738]">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mizaç</label>
                    <input type="text" name="temperament" value="<?php echo htmlspecialchars($edit_pet['temperament']); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738]">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sağlık Durumu</label>
                    <input type="text" name="health_status" value="<?php echo htmlspecialchars($edit_pet['health_status']); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738]">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Durum *</label>
                    <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738]">
                        <option value="Sahiplendirilebilir" <?php echo $edit_pet['status'] == 'Sahiplendirilebilir' ? 'selected' : ''; ?>>Sahiplendirilebilir</option>
                        <option value="Sahiplendirildi" <?php echo $edit_pet['status'] == 'Sahiplendirildi' ? 'selected' : ''; ?>>Sahiplendirildi</option>
                        <option value="Tedavi Altında" <?php echo $edit_pet['status'] == 'Tedavi Altında' ? 'selected' : ''; ?>>Tedavi Altında</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Açıklama</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738]"><?php echo htmlspecialchars($edit_pet['description']); ?></textarea>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Yeni Resim</label>
                <?php if (!empty($edit_pet['image'])): ?>
                    <div class="mb-2">
                        <img src="../assets/images/<?php echo htmlspecialchars($edit_pet['image']); ?>" alt="Mevcut resim" class="w-32 h-32 object-cover rounded-lg">
                    </div>
                <?php endif; ?>
                <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738]">
            </div>
            
            <div class="flex gap-4">
                <button type="submit" class="bg-[#705738] text-white px-8 py-3 rounded-lg font-semibold hover:bg-[#5a4225]">Güncelle</button>
                <a href="manage-pets.php" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300">İptal</a>
            </div>
        </form>
    </div>
<?php endif; ?>

<!-- Arama ve Filtreler -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <form method="GET" class="flex gap-4">
        <input type="text" name="search" placeholder="Hayvan ara..." value="<?php echo htmlspecialchars($search); ?>" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738]">
        <button type="submit" class="bg-[#705738] text-white px-6 py-2 rounded-lg font-semibold hover:bg-[#5a4225]">Ara</button>
        <?php if (!empty($search)): ?>
            <a href="manage-pets.php" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-300">Temizle</a>
        <?php endif; ?>
    </form>
</div>

<!-- Hayvanlar Listesi -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-xl font-bold text-gray-800">Tüm Hayvanlar (<?php echo count($pets); ?>)</h3>
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
                <?php if (!empty($pets)): ?>
                    <?php foreach ($pets as $pet): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <?php if (!empty($pet['image']) && file_exists('../assets/images/' . $pet['image'])): ?>
                                    <img src="../assets/images/<?php echo htmlspecialchars($pet['image']); ?>" alt="<?php echo htmlspecialchars($pet['name']); ?>" class="w-16 h-16 rounded-lg object-cover">
                                <?php else: ?>
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center text-2xl">
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
                                <div class="flex gap-2">
                                    <a href="manage-pets.php?edit=<?php echo $pet['id']; ?>" class="text-blue-600 hover:text-blue-800" title="Düzenle">
                                        <span class="material-symbols-outlined text-xl">edit</span>
                                    </a>
                                    <a href="manage-pets.php?delete=<?php echo $pet['id']; ?>" onclick="return confirm('Bu hayvanı silmek istediğinizden emin misiniz?')" class="text-red-600 hover:text-red-800" title="Sil">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </a>
                                </div>
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
