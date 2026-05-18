<?php
require_once 'auth_check.php';
require_once '../includes/db.php';

$page_title = 'Yeni Hayvan Ekle';
$success_message = '';
$error_message = '';

// Form gönderildi mi?
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    
    // Resim yükleme
    $image_name = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $file_type = $_FILES['image']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image_name = 'pet_' . time() . '_' . rand(1000, 9999) . '.' . $file_extension;
            $upload_path = '../assets/images/' . $image_name;
            
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                $error_message = "Resim yüklenirken bir hata oluştu.";
            }
        } else {
            $error_message = "Sadece JPG, PNG ve GIF formatları desteklenir.";
        }
    }
    
    // Hata yoksa veritabanına ekle
    if (empty($error_message)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO pets (name, type, breed, age, gender, size, color, temperament, health_status, description, status, image, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $type, $breed, $age, $gender, $size, $color, $temperament, $health_status, $description, $status, $image_name]);
            
            $success_message = "Hayvan başarıyla eklendi!";
            
            // Formu temizle
            $_POST = array();
        } catch (PDOException $e) {
            $error_message = "Veritabanı hatası: " . $e->getMessage();
        }
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

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
    <form method="POST" enctype="multipart/form-data" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- İsim -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Hayvan İsmi *</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738] focus:border-transparent" placeholder="Örn: Pamuk">
            </div>
            
            <!-- Tür -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tür *</label>
                <select name="type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738] focus:border-transparent">
                    <option value="">Seçiniz</option>
                    <option value="Köpek">Köpek</option>
                    <option value="Kedi">Kedi</option>
                </select>
            </div>
            
            <!-- Cins -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Cins</label>
                <input type="text" name="breed" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738] focus:border-transparent" placeholder="Örn: Golden Retriever">
            </div>
            
            <!-- Yaş -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Yaş *</label>
                <input type="number" name="age" required min="0" max="30" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738] focus:border-transparent" placeholder="Yaş">
            </div>
            
            <!-- Cinsiyet -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Cinsiyet *</label>
                <select name="gender" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738] focus:border-transparent">
                    <option value="">Seçiniz</option>
                    <option value="Erkek">Erkek</option>
                    <option value="Dişi">Dişi</option>
                </select>
            </div>
            
            <!-- Büyüklük -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Büyüklük</label>
                <select name="size" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738] focus:border-transparent">
                    <option value="">Seçiniz</option>
                    <option value="Küçük">Küçük</option>
                    <option value="Orta">Orta</option>
                    <option value="Büyük">Büyük</option>
                </select>
            </div>
            
            <!-- Renk -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Renk</label>
                <input type="text" name="color" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738] focus:border-transparent" placeholder="Örn: Beyaz">
            </div>
            
            <!-- Mizaç -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Mizaç (virgülle ayırın)</label>
                <input type="text" name="temperament" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738] focus:border-transparent" placeholder="Örn: Sevimli, Oyuncu, Sakin">
            </div>
            
            <!-- Sağlık Durumu -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Sağlık Durumu</label>
                <select name="health_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738] focus:border-transparent">
                    <option value="">Seçiniz</option>
                    <option value="Sağlıklı">Sağlıklı</option>
                    <option value="Tedavi Altında">Tedavi Altında</option>
                    <option value="Özel Bakım Gerektirir">Özel Bakım Gerektirir</option>
                </select>
            </div>
            
            <!-- Durum -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Durum *</label>
                <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738] focus:border-transparent">
                    <option value="Sahiplendirilebilir">Sahiplendirilebilir</option>
                    <option value="Sahiplendirildi">Sahiplendirildi</option>
                    <option value="Tedavi Altında">Tedavi Altında</option>
                </select>
            </div>
        </div>
        
        <!-- Açıklama -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Açıklama</label>
            <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738] focus:border-transparent" placeholder="Hayvan hakkında detaylı bilgi..."></textarea>
        </div>
        
        <!-- Resim Yükleme -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Resim</label>
            <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#705738] focus:border-transparent">
            <p class="text-sm text-gray-500 mt-1">JPG, PNG veya GIF formatında. Maksimum 5MB.</p>
        </div>
        
        <!-- Butonlar -->
        <div class="flex gap-4">
            <button type="submit" class="bg-[#705738] text-white px-8 py-3 rounded-lg font-semibold hover:bg-[#5a4225] transition-colors">
                Hayvanı Ekle
            </button>
            <a href="dashboard.php" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                İptal
            </a>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
