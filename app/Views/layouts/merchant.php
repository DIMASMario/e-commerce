<?php
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Merchant Dashboard - Socksin' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/merchant.css') ?>">
</head>
<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <!-- Sidebar -->
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-primary">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="<?= base_url('merchant/dashboard') ?>" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">Toko Merchant</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="<?= base_url('merchant/dashboard') ?>" class="nav-link align-middle px-0 text-white">
                                <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('merchant/products') ?>" class="nav-link px-0 align-middle text-white">
                                <i class="fs-4 bi-box"></i> <span class="ms-1 d-none d-sm-inline">Produk Saya</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('merchant/orders') ?>" class="nav-link px-0 align-middle text-white">
                                <i class="fs-4 bi-bag"></i> <span class="ms-1 d-none d-sm-inline">Pesanan Masuk</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('merchant/profile') ?>" class="nav-link px-0 align-middle text-white">
                                <i class="fs-4 bi-shop"></i> <span class="ms-1 d-none d-sm-inline">Profil Toko</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('merchant/stats') ?>" class="nav-link px-0 align-middle text-white">
                                <i class="fs-4 bi-bar-chart"></i> <span class="ms-1 d-none d-sm-inline">Statistik</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown pb-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name=<?= session()->get('name') ?>" alt="Merchant" width="30" height="30" class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1"><?= session()->get('name') ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li><a class="dropdown-item" href="<?= base_url() ?>">Kembali ke Beranda</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Content -->
            <div class="col py-3">
                <h2 class="mb-4"><?= $title ?? 'Dashboard Merchant' ?></h2>
                
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/merchant.js') ?>"></script>
</body>
</html>