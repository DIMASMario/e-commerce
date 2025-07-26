<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Socksin - Toko Online Kaos Kaki' ?></title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png') ?>" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <!-- Header & Navigation -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <div class="container">
                <a class="navbar-brand" href="<?= base_url('/') ?>">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="Socksin Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link <?= current_url() == base_url('/') ? 'active' : '' ?>" href="<?= base_url('/') ?>">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(current_url(), 'products') !== false ? 'active' : '' ?>" href="<?= base_url('products') ?>">Produk</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Kategori
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                <?php 
                                $db = \Config\Database::connect();
                                $categories = $db->table('categories')->get()->getResultArray();
                                foreach ($categories as $category): 
                                ?>
                                <li><a class="dropdown-item" href="<?= base_url('categories/' . $category['id']) ?>"><?= $category['name'] ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('about') ?>">Tentang Kami</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('contact') ?>">Kontak</a>
                        </li>
                    </ul>
                    
                    <div class="d-flex align-items-center">
                        <form class="d-flex me-2" action="<?= base_url('search') ?>" method="get">
                            <div class="input-group">
                                <input class="form-control" type="search" name="q" placeholder="Cari kaos kaki..." aria-label="Search" value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                        
                        <?php if (session()->get('isLoggedIn')): ?>
                            <?php 
                            $cartCount = 0;
                            if (session()->get('id')) {
                                $cartModel = new \App\Models\CartModel();
                                $cartCount = $cartModel->where('user_id', session()->get('id'))->countAllResults();
                            }
                            ?>
                            <a href="<?= base_url('cart') ?>" class="btn btn-outline-primary position-relative me-2">
                                <i class="bi bi-cart"></i>
                                <?php if ($cartCount > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?= $cartCount ?>
                                </span>
                                <?php endif; ?>
                            </a>
                            
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i>
                                    <?= session()->get('name') ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <?php if (session()->get('role') == 'admin'): ?>
                                        <li><a class="dropdown-item" href="<?= base_url('admin/dashboard') ?>"><i class="bi bi-speedometer2 me-2"></i>Dashboard Admin</a></li>
                                    <?php elseif (session()->get('role') == 'merchant'): ?>
                                        <li><a class="dropdown-item" href="<?= base_url('merchant/dashboard') ?>"><i class="bi bi-shop me-2"></i>Dashboard Merchant</a></li>
                                    <?php else: ?>
                                        <li><a class="dropdown-item" href="<?= base_url('user/dashboard') ?>"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('user/orders') ?>"><i class="bi bi-bag me-2"></i>Pesanan Saya</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('user/wishlist') ?>"><i class="bi bi-heart me-2"></i>Wishlist</a></li>
                                    <?php endif; ?>
                                    <li><a class="dropdown-item" href="<?= base_url('user/profile') ?>"><i class="bi bi-person me-2"></i>Profil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="<?= base_url('auth/login') ?>" class="btn btn-outline-primary me-2">Masuk</a>
                            <a href="<?= base_url('auth/register') ?>" class="btn btn-primary">Daftar</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content with 60px top padding for fixed navbar -->
    <main style="padding-top: 76px;">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5>Tentang Socksin</h5>
                    <p class="text-muted">Socksin adalah platform e-commerce terpercaya yang fokus pada penjualan kaos kaki berkualitas tinggi dengan berbagai model dan motif yang trendi.</p>
                    <div class="social-icons">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <h5>Informasi</h5>
                    <ul class="footer-links">
                        <li><a href="<?= base_url('about') ?>">Tentang Kami</a></li>
                        <li><a href="<?= base_url('contact') ?>">Kontak</a></li>
                        <li><a href="<?= base_url('faq') ?>">FAQ</a></li>
                        <li><a href="<?= base_url('privacy-policy') ?>">Kebijakan Privasi</a></li>
                        <li><a href="<?= base_url('terms') ?>">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <h5>Kategori</h5>
                    <ul class="footer-links">
                        <?php foreach (array_slice($categories, 0, 5) as $category): ?>
                            <li><a href="<?= base_url('categories/' . $category['id']) ?>"><?= $category['name'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4 mb-4">
                    <h5>Berlangganan</h5>
                    <p class="text-muted">Dapatkan update terbaru dan promo spesial dari Socksin</p>
                    <form action="#" class="d-flex">
                        <input type="email" class="form-control me-2" placeholder="Email Anda">
                        <button class="btn btn-primary">Daftar</button>
                    </form>
                    <div class="mt-3">
                        <h5>Metode Pembayaran</h5>
                        <img src="<?= base_url('assets/images/payment-methods.png') ?>" alt="Payment Methods" class="img-fluid mt-2" style="max-height: 30px;">
                    </div>
                </div>
            </div>
            <hr class="text-muted">
            <div class="text-center py-3">
                <p class="mb-0">&copy; <?= date('Y') ?> Socksin. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
<button id="back-to-top" title="Back to Top">
    <i class="bi bi-arrow-up"></i>
</button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/js/script.js') ?>"></script>
</body>
</html>