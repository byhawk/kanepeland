<?php
// Evantis Home - Career Page
require_once 'includes/config.php';
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kariyer - Evantis Home</title>
    <meta name="description" content="Evantis Home ailesine katılın. Açık pozisyonlarımız ve kariyer fırsatları.">

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
                    <li class="breadcrumb-item active">Kariyer</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Career Hero -->
    <section class="career-hero py-5 text-center" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
        <div class="container">
            <div class="text-white">
                <h1 class="display-4 mb-3">Evantis Home Ailesine Katılın</h1>
                <p class="lead">Birlikte başarıya ulaşalım. Sizinle büyümek istiyoruz!</p>
            </div>
        </div>
    </section>

    <!-- Why Join Us -->
    <section class="why-join py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-3">Neden Evantis Home?</h2>
                <p class="text-muted">Çalışanlarımıza sunduğumuz fırsatlar ve değerler</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="benefit-card text-center h-100">
                        <div class="icon-circle mb-3">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Kariyer Gelişimi</h5>
                        <p class="text-muted">Sürekli eğitim ve gelişim programları ile kariyer fırsatları</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="benefit-card text-center h-100">
                        <div class="icon-circle mb-3">
                            <i class="fas fa-heart fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Sağlık & Yaşam</h5>
                        <p class="text-muted">Özel sağlık sigortası ve yaşam sigortası avantajları</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="benefit-card text-center h-100">
                        <div class="icon-circle mb-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Ekip Ruhu</h5>
                        <p class="text-muted">Pozitif çalışma ortamı ve güçlü ekip kültürü</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="benefit-card text-center h-100">
                        <div class="icon-circle mb-3">
                            <i class="fas fa-trophy fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Başarı Ödülleri</h5>
                        <p class="text-muted">Performans bazlı prim ve ödül sistemi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Open Positions -->
    <section class="open-positions py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-3">Açık Pozisyonlar</h2>
                <p class="text-muted">Ekibimize katılmak için başvurun</p>
            </div>
            <div class="row g-4">
                <!-- Position 1 -->
                <div class="col-lg-6">
                    <div class="position-card">
                        <div class="position-header">
                            <h4 class="mb-2">Satış Danışmanı</h4>
                            <span class="badge bg-primary">Tam Zamanlı</span>
                            <span class="badge bg-secondary">İstanbul</span>
                        </div>
                        <div class="position-body">
                            <p class="text-muted mb-3">
                                Showroom'larımızda müşteri ilişkileri ve satış süreçlerini yönetecek deneyimli satış danışmanları arıyoruz.
                            </p>
                            <div class="requirements mb-3">
                                <h6>Aranan Nitelikler:</h6>
                                <ul>
                                    <li>En az 2 yıl satış deneyimi</li>
                                    <li>İyi iletişim becerileri</li>
                                    <li>Müşteri odaklı çalışma</li>
                                </ul>
                            </div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applyModal">
                                <i class="fas fa-paper-plane me-2"></i> Başvuru Yap
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Position 2 -->
                <div class="col-lg-6">
                    <div class="position-card">
                        <div class="position-header">
                            <h4 class="mb-2">Grafik Tasarımcı</h4>
                            <span class="badge bg-primary">Tam Zamanlı</span>
                            <span class="badge bg-secondary">İstanbul</span>
                        </div>
                        <div class="position-body">
                            <p class="text-muted mb-3">
                                Pazarlama ekibimizde görev alacak yaratıcı grafik tasarımcılar arıyoruz.
                            </p>
                            <div class="requirements mb-3">
                                <h6>Aranan Nitelikler:</h6>
                                <ul>
                                    <li>Adobe Creative Suite (Photoshop, Illustrator)</li>
                                    <li>En az 2 yıl tecrübe</li>
                                    <li>Portföy sahibi olmak</li>
                                </ul>
                            </div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applyModal">
                                <i class="fas fa-paper-plane me-2"></i> Başvuru Yap
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Position 3 -->
                <div class="col-lg-6">
                    <div class="position-card">
                        <div class="position-header">
                            <h4 class="mb-2">Depo Sorumlusu</h4>
                            <span class="badge bg-primary">Tam Zamanlı</span>
                            <span class="badge bg-secondary">Ankara</span>
                        </div>
                        <div class="position-body">
                            <p class="text-muted mb-3">
                                Depo operasyonlarını yönetecek deneyimli depo sorumlusu arıyoruz.
                            </p>
                            <div class="requirements mb-3">
                                <h6>Aranan Nitelikler:</h6>
                                <ul>
                                    <li>Lojistik veya depo yönetimi deneyimi</li>
                                    <li>Stok takibi ve envanter bilgisi</li>
                                    <li>Ekip yönetimi becerisi</li>
                                </ul>
                            </div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applyModal">
                                <i class="fas fa-paper-plane me-2"></i> Başvuru Yap
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Position 4 -->
                <div class="col-lg-6">
                    <div class="position-card">
                        <div class="position-header">
                            <h4 class="mb-2">Dijital Pazarlama Uzmanı</h4>
                            <span class="badge bg-primary">Tam Zamanlı</span>
                            <span class="badge bg-secondary">İstanbul</span>
                        </div>
                        <div class="position-body">
                            <p class="text-muted mb-3">
                                Dijital pazarlama stratejilerini yönetecek deneyimli uzmanlar arıyoruz.
                            </p>
                            <div class="requirements mb-3">
                                <h6>Aranan Nitelikler:</h6>
                                <ul>
                                    <li>SEO, SEM, sosyal medya deneyimi</li>
                                    <li>Google Analytics, Ads bilgisi</li>
                                    <li>En az 3 yıl tecrübe</li>
                                </ul>
                            </div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applyModal">
                                <i class="fas fa-paper-plane me-2"></i> Başvuru Yap
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Application Modal -->
    <div class="modal fade" id="applyModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">İş Başvurusu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Ad Soyad *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">E-posta *</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telefon *</label>
                                <input type="tel" class="form-control" name="phone" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Başvurduğunuz Pozisyon *</label>
                                <select class="form-select" name="position" required>
                                    <option value="">Seçiniz...</option>
                                    <option>Satış Danışmanı</option>
                                    <option>Grafik Tasarımcı</option>
                                    <option>Depo Sorumlusu</option>
                                    <option>Dijital Pazarlama Uzmanı</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Özgeçmiş (CV) *</label>
                                <input type="file" class="form-control" name="cv" accept=".pdf,.doc,.docx" required>
                                <small class="text-muted">PDF, DOC veya DOCX formatında (Max 5MB)</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Ön Yazı</label>
                                <textarea class="form-control" name="cover_letter" rows="4" placeholder="Kendinizi tanıtın..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i> Başvuruyu Gönder
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
