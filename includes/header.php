<!-- Header -->
<header class="main-header">
    <!-- Top Bar -->
    <div class="top-bar bg-dark text-white py-2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="contact-info">
                        <a href="tel:+905551234567"><i class="fas fa-phone"></i> 0555 123 45 67</a>
                        <a href="mailto:info@evantishome.com"><i class="fas fa-envelope"></i> info@evantishome.com</a>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/images/logo.png" alt="Evantis Home" height="50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Ana Sayfa</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            Kategoriler
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="category.php?cat=koltuk-takimi">Koltuk Takımı</a></li>
                            <li><a class="dropdown-item" href="category.php?cat=yatak-odasi">Yatak Odası</a></li>
                            <li><a class="dropdown-item" href="category.php?cat=yemek-odasi">Yemek Odası</a></li>
                            <li><a class="dropdown-item" href="category.php?cat=genc-odasi">Genç Odası</a></li>
                            <li><a class="dropdown-item" href="category.php?cat=tv-unitesi">TV Ünitesi</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="products.php">Tüm Ürünler</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Ürünler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">Hakkımızda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">İletişim</a>
                    </li>
                </ul>
                <div class="navbar-actions">
                    <form action="search.php" method="GET" class="search-form me-3">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Ürün ara...">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                    <a href="favorites.php" class="btn btn-icon" title="Favoriler">
                        <i class="far fa-heart"></i>
                        <span class="badge">0</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>
