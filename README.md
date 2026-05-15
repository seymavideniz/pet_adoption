# 🐾 Evcil Hayvan Sahiplendirme Web Sitesi

Modern ve kullanıcı dostu bir evcil hayvan sahiplendirme platformu. XAMPP, PHP ve MySQL kullanılarak geliştirilmiştir.

## 📁 Proje Yapısı

```
pet_adoption/
│
├── includes/              # Ortak PHP dosyaları
│   ├── db.php            # Veritabanı bağlantısı (PDO)
│   ├── header.php        # Site başlığı ve navigasyon
│   └── footer.php        # Site alt bilgisi
│
├── assets/               # Statik dosyalar
│   ├── css/
│   │   ├── global.css    # Renk değişkenleri, tipografi, reset
│   │   ├── layout.css    # Grid, flexbox, responsive tasarım
│   │   └── components.css # Butonlar, kartlar, formlar
│   └── images/           # Görsel dosyaları
│
├── index.php             # Ana sayfa
├── sahiplen.php          # Evcil hayvan listesi
├── iletisim.php          # İletişim formu
├── database.sql          # Veritabanı yapısı ve örnek veriler
└── README.md             # Proje dokümantasyonu

```

## 🚀 Kurulum Adımları

### 1. XAMPP Kontrolü
- XAMPP'ın yüklü olduğundan emin olun
- Apache ve MySQL servislerini başlatın

### 2. Veritabanı Kurulumu
1. phpMyAdmin'i açın: `http://localhost/phpmyadmin`
2. `database.sql` dosyasını içe aktarın veya dosyadaki SQL kodlarını çalıştırın
3. `pet_adoption` veritabanının oluştuğunu kontrol edin

### 3. Projeyi Çalıştırma
1. Tarayıcınızda `http://localhost/pet_adoption` adresine gidin
2. Ana sayfa açılmalıdır

## 🎯 Özellikler

### ✅ Teknik Özellikler
- **Semantic HTML**: Div yığınları yerine `<main>`, `<section>`, `<article>` kullanımı
- **Class-Based CSS**: ID seçici kullanılmamış, tamamen class-based yapı
- **CSS Variables**: Renk ve spacing değerleri için merkezi değişkenler
- **Responsive Tasarım**: Mobil, tablet ve desktop uyumlu
- **PDO Veritabanı**: Güvenli ve modern veritabanı erişimi
- **Form Validation**: Server-side doğrulama ve hata yönetimi
- **Modüler Yapı**: Yeniden kullanılabilir bileşenler

### 🎨 Tasarım Özellikleri
- Modern ve minimalist arayüz
- Yumuşak renk paleti
- Hover efektleri ve animasyonlar
- Accessibility (erişilebilirlik) standartlarına uygun
- Tutarlı spacing ve tipografi

## 📱 Sayfalar

### 1. Ana Sayfa (index.php)
- Hero bölümü
- Platform özellikleri
- İstatistikler
- CTA (Call-to-Action) bölümü

### 2. Sahiplen Sayfası (sahiplen.php)
- Veritabanından evcil hayvanları listeler
- Filtreleme ve kart görünümü
- Sahiplenme durumu gösterimi
- İletişim formuna yönlendirme

### 3. İletişim Sayfası (iletisim.php)
- Form validasyonu
- Hata ve başarı mesajları
- İletişim bilgileri
- Evcil hayvan özel mesajları (sahiplen.php'den gelen)

## 🛠️ Kullanılan Teknolojiler

- **Backend**: PHP 7.4+
- **Veritabanı**: MySQL 5.7+ / MariaDB
- **Frontend**: HTML5, CSS3
- **Veritabanı Erişimi**: PDO (PHP Data Objects)
- **Sunucu**: XAMPP (Apache)

## 🎨 CSS Mimarisi

### global.css
- CSS Variables (renk paleti)
- CSS Reset
- Tipografi kuralları
- Utility classes

### layout.css
- Container ve grid sistemleri
- Header ve footer düzenleri
- Responsive media queries
- Flexbox yapıları

### components.css
- Buton stilleri
- Kart bileşenleri
- Form elemanları
- Alert mesajları
- Badge ve diğer UI elemanları

## 📊 Veritabanı Yapısı

### pets Tablosu
- `id`: Benzersiz kimlik
- `name`: Hayvan adı
- `type`: Tür (Köpek, Kedi, vb.)
- `breed`: Cins
- `age`: Yaş
- `gender`: Cinsiyet
- `description`: Açıklama
- `image`: Görsel dosya adı
- `status`: Sahiplenme durumu
- `created_at`, `updated_at`: Zaman damgaları

## 🔐 Güvenlik

- PDO Prepared Statements (SQL Injection koruması)
- `htmlspecialchars()` ile XSS koruması
- Form validasyonu (client & server-side)
- Güvenli veritabanı bağlantısı

## 📝 Geliştirme Notları

### Yapılabilecek İyileştirmeler
- Admin paneli eklenebilir
- Görsel yükleme sistemi
- Gelişmiş filtreleme (tür, yaş, cinsiyet)
- Favori listesi
- Kullanıcı kayıt/giriş sistemi
- E-posta gönderimi (iletişim formu için)
- Sayfalama (pagination)

### Best Practices
- Her PHP dosyası `require_once` ile header ve footer içerir
- Tüm veritabanı sorguları PDO prepared statements kullanır
- CSS class naming convention tutarlıdır
- Responsive breakpoints: 480px, 768px, 1400px

## 📞 Destek

Proje hakkında sorularınız için iletişim sayfasından ulaşabilirsiniz.

## 📄 Lisans

Bu proje eğitim amaçlı geliştirilmiştir.

---

**Geliştirme Tarihi**: 2026
**Versiyon**: 1.0.0
