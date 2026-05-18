<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Admin Paneli'; ?> - PatiKapısı</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts & Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Manrope', sans-serif;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#2D2419] text-white flex-shrink-0">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-[#E3C19A]">🐾 PatiKapısı</h1>
                <p class="text-sm text-gray-400 mt-1">Admin Paneli</p>
            </div>
            
            <nav class="mt-6">
                <a href="dashboard.php" class="flex items-center gap-3 px-6 py-3 text-gray-300 hover:bg-[#3a302a] hover:text-white transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'bg-[#3a302a] text-white border-l-4 border-[#E3C19A]' : ''; ?>">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>Dashboard</span>
                </a>
                
                <a href="add-pet.php" class="flex items-center gap-3 px-6 py-3 text-gray-300 hover:bg-[#3a302a] hover:text-white transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'add-pet.php' ? 'bg-[#3a302a] text-white border-l-4 border-[#E3C19A]' : ''; ?>">
                    <span class="material-symbols-outlined">add_circle</span>
                    <span>Hayvan Ekle</span>
                </a>
                
                <a href="manage-pets.php" class="flex items-center gap-3 px-6 py-3 text-gray-300 hover:bg-[#3a302a] hover:text-white transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'manage-pets.php' ? 'bg-[#3a302a] text-white border-l-4 border-[#E3C19A]' : ''; ?>">
                    <span class="material-symbols-outlined">pets</span>
                    <span>Hayvanları Yönet</span>
                </a>
                
                <a href="applications.php" class="flex items-center gap-3 px-6 py-3 text-gray-300 hover:bg-[#3a302a] hover:text-white transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'applications.php' ? 'bg-[#3a302a] text-white border-l-4 border-[#E3C19A]' : ''; ?>">
                    <span class="material-symbols-outlined">description</span>
                    <span>Başvurular</span>
                </a>
                
                <div class="border-t border-gray-700 my-4"></div>
                
                <a href="../index.php" class="flex items-center gap-3 px-6 py-3 text-gray-300 hover:bg-[#3a302a] hover:text-white transition-colors">
                    <span class="material-symbols-outlined">home</span>
                    <span>Siteye Git</span>
                </a>
                
                <a href="../logout.php" class="flex items-center gap-3 px-6 py-3 text-gray-300 hover:bg-[#3a302a] hover:text-red-400 transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Çıkış Yap</span>
                </a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800"><?php echo $page_title ?? 'Dashboard'; ?></h2>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-800"><?php echo $admin_name; ?></p>
                            <p class="text-xs text-gray-500">Admin</p>
                        </div>
                        <div class="w-10 h-10 bg-[#E3C19A] rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-[#2D2419]">person</span>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
