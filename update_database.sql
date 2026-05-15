-- Mevcut Veritabanını Güncelleme Scripti
-- Eğer veritabanınız zaten varsa ve yeni sütunları eklemek istiyorsanız bu scripti kullanın

USE pet_adoption;

-- Yeni sütunları ekle (eğer mevcut değilse)
ALTER TABLE pets 
ADD COLUMN IF NOT EXISTS size VARCHAR(20) DEFAULT NULL AFTER gender,
ADD COLUMN IF NOT EXISTS story TEXT AFTER description,
ADD COLUMN IF NOT EXISTS temperament VARCHAR(255) AFTER story;

-- Eğer size sütunu ENUM ise, VARCHAR'a çevir
ALTER TABLE pets MODIFY COLUMN size VARCHAR(20) DEFAULT NULL;

-- Mevcut kayıtları güncelle (örnek veriler)
UPDATE pets SET 
    size = '3kg',
    story = CONCAT(name, ' için özel bir hikaye yazılacak.'),
    temperament = 'Sevimli, Oyuncu, Sosyal'
WHERE size IS NULL OR size = '';

-- Pamuk için özel güncelleme
UPDATE pets SET 
    size = '4kg',
    story = 'Pamuk, 6 aylıkken sokakta bulundu. Şimdi sağlıklı ve mutlu bir kedi. Ailesi tarafından çok sevilecek ve güvenli bir yuva arıyor.',
    temperament = 'Sevimli, Oyuncu, Sosyal'
WHERE name = 'Pamuk';

-- Karabaş için özel güncelleme
UPDATE pets SET 
    size = '32kg',
    story = 'Karabaş, sahibi tarafından bırakıldı ancak o hala insanlara güveniyor ve sevgi arıyor. Aktif bir aile için mükemmel bir dosttur.',
    temperament = 'Enerjik, Sadık, Eğitimli'
WHERE name = 'Karabaş';

-- Minnoş için özel güncelleme
UPDATE pets SET 
    size = '2.5kg',
    story = 'Minnoş, yavru olarak kurtarıldı ve şimdi sağlıklı bir kedi. Sevgi dolu bir yuva arıyor.',
    temperament = 'Sevimli, Meraklı, Aktif'
WHERE name = 'Minnoş';

-- Çomar için özel güncelleme
UPDATE pets SET 
    size = '28kg',
    story = 'Çomar, eski sahipleri tarafından terk edildi. Çok sadık ve zeki bir köpek. Aktif bir yaşam tarzına uygun.',
    temperament = 'Zeki, Aktif, Sosyal'
WHERE name = 'Çomar';

-- Sarı için özel güncelleme
UPDATE pets SET 
    size = '15kg',
    story = 'Sarı, yavru olarak sokaklarda bulundu. Şimdi sağlıklı ve mutlu. Çocuklarla harika anlaşıyor.',
    temperament = 'Sevecen, Sadık, Oyuncu'
WHERE name = 'Sarı';

-- Duman için özel güncelleme
UPDATE pets SET 
    size = '4.5kg',
    story = 'Duman, sakin ve zarif bir kedi. Sessiz bir yuva arıyor.',
    temperament = 'Zarif, Kibar, Sakin'
WHERE name = 'Duman';

-- Şanslı için özel güncelleme
UPDATE pets SET 
    size = '12kg',
    story = 'Şanslı, çok meraklı ve öğrenmeye açık bir yavru. Ailesine çok bağlı olacak.',
    temperament = 'Enerjik, Meraklı, Öğrenmeye Açık'
WHERE name = 'Şanslı';

SELECT 'Veritabanı başarıyla güncellendi!' AS mesaj;
