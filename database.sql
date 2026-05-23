-- Evcil hayvanlar tablosu
CREATE TABLE IF NOT EXISTS pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type ENUM('Köpek', 'Kedi') NOT NULL,
    breed VARCHAR(100),
    age INT NOT NULL,
    gender ENUM('Erkek', 'Dişi') NOT NULL,
    size VARCHAR(20) DEFAULT NULL,
    description TEXT,
    story TEXT,
    temperament VARCHAR(255),
    image VARCHAR(255),
    status ENUM('Sahiplendirilebilir', 'Sahiplendirildi') DEFAULT 'Sahiplendirilebilir',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_type (type),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Örnek veriler ekle
INSERT INTO pets (name, type, breed, age, gender, size, description, story, temperament, status) VALUES
('Pamuk', 'Kedi', 'Van Kedisi', 2, 'Dişi', '4kg', 'Çok sevecen ve oyuncu bir kedi. Çocuklarla iyi geçinir. Tuvalet eğitimi almıştır.', 'Pamuk, 6 aylıkken sokakta bulundu. Şimdi sağlıklı ve mutlu bir kedi. Ailesi tarafından çok sevilecek ve güvenli bir yuva arıyor.', 'Sevimli, Oyuncu, Sosyal', 'Sahiplendirilebilir'),
('Karabaş', 'Köpek', 'Golden Retriever', 3, 'Erkek', '32kg', 'Çok enerjik ve sadık bir köpek. Günlük egzersiz ihtiyacı vardır. Eğitimli ve itaatkardır.', 'Karabaş, sahibi tarafından bırakıldı ancak o hala insanlara güveniyor ve sevgi arıyor. Aktif bir aile için mükemmel bir dosttur.', 'Enerjik, Sadık, Eğitimli', 'Sahiplendirilebilir'),
('Minnoş', 'Kedi', 'Tekir', 1, 'Dişi', '2.5kg', 'Genç ve sevimli bir kedi. İlgi ve sevgi bekliyor. Aşıları tamdır.', 'Minnoş, yavru olarak kurtarıldı ve şimdi sağlıklı bir kedi. Sevgi dolu bir yuva arıyor.', 'Sevimli, Meraklı, Aktif', 'Sahiplendirilebilir'),
('Çomar', 'Köpek', 'Husky', 4, 'Erkek', '28kg', 'Çok zeki ve aktif bir köpek. Geniş bir yaşam alanı tercih eder. Sosyaldir.', 'Çomar, eski sahipleri tarafından terk edildi. Çok sadık ve zeki bir köpek. Aktif bir yaşam tarzına uygun.', 'Zeki, Aktif, Sosyal', 'Sahiplendirilebilir'),
('Boncuk', 'Kedi', 'British Shorthair', 5, 'Dişi', '5kg', 'Sakin ve uyumlu bir kedi. Evde rahat yaşayabilir. Temiz ve bakımlıdır.', 'Boncuk, sessiz ve sakin bir kedi. Rahat bir ev ortamı arıyor.', 'Sakin, Uyumlu, Temiz', 'Sahiplendirildi'),
('Sarı', 'Köpek', 'Melez', 2, 'Erkek', '15kg', 'Orta boy, sevecen bir köpek. Çocukları çok sever. Sadık bir dost arıyorsanız tam size göre.', 'Sarı, yavru olarak sokaklarda bulundu. Şimdi sağlıklı ve mutlu. Çocuklarla harika anlaşıyor.', 'Sevecen, Sadık, Oyuncu', 'Sahiplendirilebilir'),
('Duman', 'Kedi', 'Ankara Kedisi', 3, 'Erkek', '4.5kg', 'Zarif ve kibar bir kedi. Sessiz bir ortamı tercih eder. Aşıları ve kısırlaştırma işlemi yapılmıştır.', 'Duman, sakin ve zarif bir kedi. Sessiz bir yuva arıyor.', 'Zarif, Kibar, Sakin', 'Sahiplendirilebilir'),
('Şanslı', 'Köpek', 'Beagle', 1, 'Erkek', '12kg', 'Çok enerjik ve meraklı bir köpek yavrusu. Eğitim almaya hazır. Ailelerle yaşamaya uygun.', 'Şanslı, çok meraklı ve öğrenmeye açık bir yavru. Ailesine çok bağlı olacak.', 'Enerjik, Meraklı, Öğrenmeye Açık', 'Sahiplendirilebilir');

-- İletişim mesajları tablosu (opsiyonel - gelecekte kullanılmak üzere)
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    pet_id INT NULL,
    status ENUM('Yeni', 'Okundu', 'Yanıtlandı') DEFAULT 'Yeni',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pet_id) REFERENCES pets(id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
