<?php
// Evantis Home - Terms and Conditions Page
require_once 'includes/config.php';
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanım Koşulları - Evantis Home</title>
    <meta name="description" content="Evantis Home kullanım koşulları ve satış sözleşmesi.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <div class="breadcrumb-section py-3 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                    <li class="breadcrumb-item active">Kullanım Koşulları</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="legal-page py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 mx-auto">
                    <h1 class="mb-4">Kullanım Koşulları ve Satış Sözleşmesi</h1>
                    <p class="text-muted mb-4">Son Güncelleme: 15 Ocak 2025</p>

                    <div class="legal-content">
                        <!-- Section 1 -->
                        <div class="legal-section mb-4">
                            <h3 class="mb-3">1. Taraflar</h3>
                            <p><strong>SATICI:</strong></p>
                            <p>
                                <strong>Ünvan:</strong> Evantis Home Mobilya ve Dekorasyon A.Ş.<br>
                                <strong>Adres:</strong> Ataşehir, İstanbul, Türkiye<br>
                                <strong>Telefon:</strong> 0555 123 45 67<br>
                                <strong>E-posta:</strong> info@evantishome.com<br>
                                <strong>Mersis No:</strong> 0123456789012345
                            </p>
                            <p><strong>ALICI:</strong> evantishome.com sitesinden sipariş veren gerçek veya tüzel kişi</p>
                        </div>

                        <!-- Section 2 -->
                        <div class="legal-section mb-4">
                            <h3 class="mb-3">2. Sözleşmenin Konusu</h3>
                            <p>
                                İşbu sözleşmenin konusu, ALICI'nın SATICI'ya ait evantishome.com internet sitesinden
                                elektronik ortamda siparişini verdiği aşağıda nitelikleri ve satış fiyatı belirtilen
                                ürün/ürünlerin satışı ve teslimi ile ilgili olarak 6502 sayılı Tüketicilerin Korunması
                                Hakkında Kanun ve Mesafeli Sözleşmeler Yönetmeliği hükümleri gereğince tarafların
                                hak ve yükümlülüklerinin saptanmasıdır.
                            </p>
                        </div>

                        <!-- Section 3 -->
                        <div class="legal-section mb-4">
                            <h3 class="mb-3">3. Sipariş ve Onay</h3>
                            <ul>
                                <li>Web sitemizdeki ürün bilgileri ve fiyatları SATICI tarafından değiştirilebilir.</li>
                                <li>Sipariş verildikten sonra, sipariş özeti ALICI'nın e-posta adresine gönderilir.</li>
                                <li>Sipariş onayı, SATICI tarafından ALICI'ya e-posta ile bildirilir.</li>
                                <li>Ürün fiyatları ve stok durumu sipariş anında geçerli olan bilgiler esas alınır.</li>
                                <li>Stokta olmayan ürünler için ALICI bilgilendirilir ve iptal/değişim hakkı tanınır.</li>
                            </ul>
                        </div>

                        <!-- Section 4 -->
                        <div class="legal-section mb-4">
                            <h3 class="mb-3">4. Ödeme Koşulları</h3>
                            <ul>
                                <li>Kredi kartı, banka kartı veya havale/EFT ile ödeme yapılabilir.</li>
                                <li>Taksitli satışlarda banka ile müşteri arasındaki sözleşme geçerlidir.</li>
                                <li>Ödeme işlemi sırasında kullanılan kart bilgileri 3D Secure sistemi ile korunur.</li>
                                <li>Sipariş tutarı, sipariş anında belirlenen fiyat üzerinden hesaplanır.</li>
                                <li>Kampanya ve indirimler SATICI tarafından belirlenmiş koşullara tabidir.</li>
                            </ul>
                        </div>

                        <!-- Section 5 -->
                        <div class="legal-section mb-4">
                            <h3 class="mb-3">5. Teslimat</h3>
                            <ul>
                                <li>Ürünler, sipariş onayından sonra 2-30 iş günü içinde teslim edilir.</li>
                                <li>Teslimat süresi, ürünün özelliğine ve bulunduğu bölgeye göre değişebilir.</li>
                                <li>Teslimat adresi olarak ALICI'nın belirttiği adres esas alınır.</li>
                                <li>Teslimat sırasında ALICI veya yetkili kişinin bulunması gerekir.</li>
                                <li>Ürün hasarlı veya kırık olarak teslim edilirse, tutanak tutularak teslim alınmamalıdır.</li>
                                <li>Kargo şirketinden kaynaklanan gecikmelerden SATICI sorumlu tutulamaz.</li>
                            </ul>
                        </div>

                        <!-- Section 6 -->
                        <div class="legal-section mb-4">
                            <h3 class="mb-3">6. Cayma Hakkı</h3>
                            <p>
                                ALICI, sözleşme konusu ürünü teslim aldığı tarihten itibaren 14 (on dört) gün içinde
                                hiçbir gerekçe göstermeksizin ve cezai şart ödemeksizin sözleşmeden cayma hakkına sahiptir.
                            </p>
                            <p><strong>Cayma Hakkı Şartları:</strong></p>
                            <ul>
                                <li>Ürün kullanılmamış, bozulmamış ve tahrip edilmemiş olmalıdır.</li>
                                <li>Ürünün orijinal ambalajı ve etiketleri sağlam olmalıdır.</li>
                                <li>Cayma hakkı talebi yazılı olarak veya kalıcı veri saklayıcısı ile bildirilmelidir.</li>
                                <li>İade edilen ürün kontrol edildikten sonra ödeme 14 gün içinde iade edilir.</li>
                            </ul>
                            <p><strong>Cayma Hakkı Kullanılamayan Durumlar:</strong></p>
                            <ul>
                                <li>Özel olarak üretilmiş veya kişiye özel hale getirilmiş ürünler</li>
                                <li>Hijyen ve sağlık açısından uygun olmayan, açılmış ürünler</li>
                                <li>Teslimden sonra ambalajı açılan ses ve görüntü kayıtları, yazılım ve kopyalanabilir materyaller</li>
                            </ul>
                        </div>

                        <!-- Section 7 -->
                        <div class="legal-section mb-4">
                            <h3 class="mb-3">7. Garanti Koşulları</h3>
                            <ul>
                                <li>Tüm ürünlerimiz 2 (iki) yıl garanti kapsamındadır.</li>
                                <li>Garanti, imalat hatalarından kaynaklanan sorunları kapsar.</li>
                                <li>Yanlış kullanım, kötü muamele veya yetkisiz tamir durumlarında garanti geçersizdir.</li>
                                <li>Garanti belgesi ve fatura ürünle birlikte saklanmalıdır.</li>
                                <li>Garanti kapsamındaki ürünler ücretsiz onarım veya değişim yapılır.</li>
                            </ul>
                        </div>

                        <!-- Section 8 -->
                        <div class="legal-section mb-4">
                            <h3 class="mb-3">8. Kişisel Verilerin Korunması</h3>
                            <p>
                                SATICI, ALICI'ya ait kişisel verileri 6698 sayılı Kişisel Verilerin Korunması
                                Kanunu kapsamında işler ve korur. Detaylı bilgi için
                                <a href="privacy.php">Gizlilik Politikamızı</a> inceleyebilirsiniz.
                            </p>
                        </div>

                        <!-- Section 9 -->
                        <div class="legal-section mb-4">
                            <h3 class="mb-3">9. Uyuşmazlıkların Çözümü</h3>
                            <p>
                                İşbu sözleşmeden doğabilecek her türlü uyuşmazlık için, Türkiye Cumhuriyeti
                                mahkemeleri ve icra daireleri yetkilidir. Tüketici işlemleri için, Tüketici
                                Hakem Heyetleri ve Tüketici Mahkemeleri yetkilidir.
                            </p>
                            <p>
                                ALICI, parasal sınırlar dahilinde şikayetlerini aşağıdaki kurumlara başvurabilir:
                            </p>
                            <ul>
                                <li>İl/İlçe Tüketici Hakem Heyetleri</li>
                                <li>Tüketici Mahkemeleri</li>
                                <li>Gümrük ve Ticaret Bakanlığı Tüketici Danışma Merkezi: 0850 220 0 220</li>
                            </ul>
                        </div>

                        <!-- Section 10 -->
                        <div class="legal-section mb-4">
                            <h3 class="mb-3">10. Yürürlük</h3>
                            <p>
                                ALICI, evantishome.com sitesinden sipariş verdiğinde işbu sözleşme hükümlerini
                                kabul etmiş sayılır. Sözleşme, sipariş onayı ile birlikte yürürlüğe girer.
                            </p>
                            <p>
                                İşbu sözleşme, elektronik ortamda ALICI tarafından okunup kabul edilmiş ve
                                6502 sayılı Tüketicinin Korunması Hakkındaki Kanun ve Mesafeli Sözleşmeler
                                Yönetmeliği hükümlerine uygun olarak düzenlenmiştir.
                            </p>
                        </div>

                        <!-- Section 11 -->
                        <div class="legal-section mb-4">
                            <h3 class="mb-3">11. İletişim</h3>
                            <p>Sorularınız için bizimle iletişime geçebilirsiniz:</p>
                            <p>
                                <strong>E-posta:</strong> info@evantishome.com<br>
                                <strong>Telefon:</strong> 0555 123 45 67<br>
                                <strong>Adres:</strong> Ataşehir, İstanbul, Türkiye<br>
                                <strong>Çalışma Saatleri:</strong> Pazartesi - Cumartesi 09:00 - 18:00
                            </p>
                        </div>

                        <div class="alert alert-success mt-5">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Onay:</strong> Sipariş vererek bu kullanım koşullarını kabul etmiş sayılırsınız.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
