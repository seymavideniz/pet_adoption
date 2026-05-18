<?php
require_once 'auth_check.php';
require_once '../includes/db.php';

$page_title = 'Sahiplenme Başvuruları';
$success_message = '';
$error_message = '';

// Başvuru durumunu güncelle
if (isset($_GET['action']) && isset($_GET['id'])) {
    $application_id = intval($_GET['id']);
    $action = $_GET['action'];
    
    $new_status = '';
    if ($action == 'approve') {
        $new_status = 'Onaylandı';
    } elseif ($action == 'reject') {
        $new_status = 'Reddedildi';
    }
    
    if (!empty($new_status)) {
        try {
            $stmt = $pdo->prepare("UPDATE applications SET status = ? WHERE id = ?");
            $stmt->execute([$new_status, $application_id]);
            $success_message = "Başvuru durumu güncellendi.";
        } catch (PDOException $e) {
            $error_message = "Güncelleme hatası: " . $e->getMessage();
        }
    }
}

// Başvuruları getir
try {
    $stmt = $pdo->query("
        SELECT a.*, p.name as pet_name, p.type as pet_type, u.full_name, u.email, u.phone 
        FROM applications a 
        LEFT JOIN pets p ON a.pet_id = p.id 
        LEFT JOIN users u ON a.user_id = u.id 
        ORDER BY a.created_at DESC
    ");
    $applications = $stmt->fetchAll();
} catch (PDOException $e) {
    // Tablo yoksa oluştur
    if ($e->getCode() == '42S02') {
        try {
            $pdo->exec("CREATE TABLE IF NOT EXISTS applications (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                pet_id INT NOT NULL,
                message TEXT,
                status VARCHAR(50) DEFAULT 'Beklemede',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id),
                FOREIGN KEY (pet_id) REFERENCES pets(id)
            )");
            $applications = [];
            $success_message = "Başvurular tablosu oluşturuldu. Henüz başvuru yok.";
        } catch (PDOException $e2) {
            $error_message = "Tablo oluşturma hatası: " . $e2->getMessage();
            $applications = [];
        }
    } else {
        $error_message = "Başvurular yüklenirken hata: " . $e->getMessage();
        $applications = [];
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

<!-- İstatistikler -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <?php
    $total = count($applications);
    $pending = count(array_filter($applications, fn($a) => $a['status'] == 'Beklemede'));
    $approved = count(array_filter($applications, fn($a) => $a['status'] == 'Onaylandı'));
    $rejected = count(array_filter($applications, fn($a) => $a['status'] == 'Reddedildi'));
    ?>
    
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <p class="text-sm text-gray-600 mb-1">Toplam Başvuru</p>
        <h3 class="text-3xl font-bold text-gray-800"><?php echo $total; ?></h3>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <p class="text-sm text-gray-600 mb-1">Bekleyen</p>
        <h3 class="text-3xl font-bold text-yellow-600"><?php echo $pending; ?></h3>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <p class="text-sm text-gray-600 mb-1">Onaylanan</p>
        <h3 class="text-3xl font-bold text-green-600"><?php echo $approved; ?></h3>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <p class="text-sm text-gray-600 mb-1">Reddedilen</p>
        <h3 class="text-3xl font-bold text-red-600"><?php echo $rejected; ?></h3>
    </div>
</div>

<!-- Başvurular Listesi -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-xl font-bold text-gray-800">Tüm Başvurular</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Başvuran</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Hayvan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">İletişim</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Mesaj</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tarih</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Durum</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">İşlemler</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if (!empty($applications)): ?>
                    <?php foreach ($applications as $app): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-gray-800"><?php echo htmlspecialchars($app['full_name'] ?? 'Bilinmiyor'); ?></p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-gray-800"><?php echo htmlspecialchars($app['pet_name'] ?? 'Bilinmiyor'); ?></p>
                                    <p class="text-sm text-gray-500"><?php echo htmlspecialchars($app['pet_type'] ?? ''); ?></p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <p class="text-gray-600"><?php echo htmlspecialchars($app['email'] ?? 'Email yok'); ?></p>
                                    <p class="text-gray-600"><?php echo htmlspecialchars($app['phone'] ?? 'Tel yok'); ?></p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600 max-w-xs truncate"><?php echo htmlspecialchars($app['message'] ?? 'Mesaj yok'); ?></p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <?php echo date('d.m.Y', strtotime($app['created_at'])); ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php
                                $status = $app['status'] ?? 'Beklemede';
                                $status_class = '';
                                if ($status == 'Beklemede') {
                                    $status_class = 'bg-yellow-100 text-yellow-700';
                                } elseif ($status == 'Onaylandı') {
                                    $status_class = 'bg-green-100 text-green-700';
                                } elseif ($status == 'Reddedildi') {
                                    $status_class = 'bg-red-100 text-red-700';
                                }
                                ?>
                                <span class="px-3 py-1 <?php echo $status_class; ?> rounded-full text-xs font-semibold"><?php echo htmlspecialchars($status); ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($app['status'] == 'Beklemede'): ?>
                                    <div class="flex gap-2">
                                        <a href="?action=approve&id=<?php echo $app['id']; ?>" onclick="return confirm('Bu başvuruyu onaylamak istediğinizden emin misiniz?')" class="text-green-600 hover:text-green-800" title="Onayla">
                                            <span class="material-symbols-outlined text-xl">check_circle</span>
                                        </a>
                                        <a href="?action=reject&id=<?php echo $app['id']; ?>" onclick="return confirm('Bu başvuruyu reddetmek istediğinizden emin misiniz?')" class="text-red-600 hover:text-red-800" title="Reddet">
                                            <span class="material-symbols-outlined text-xl">cancel</span>
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <span class="text-gray-400">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            Henüz başvuru bulunmuyor.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
