<?php
<?= $this->extend('layouts/merchant') ?>

<?= $this->section('content') ?>

<div class="row">
    <!-- Shop Info Card -->
    <div class="col-md-4 mb-4">
        <div class="card shadow">
            <div class="card-body">
                <h5 class="card-title">Informasi Toko</h5>
                <hr>
                <p><strong>Nama Toko:</strong> <?= $merchantProfile['shop_name'] ?></p>
                <p><strong>Alamat:</strong> <?= $merchantProfile['address'] ?></p>
                <p><strong>Kontak:</strong> <?= $merchantProfile['contact'] ?></p>
                <p><strong>Bergabung Sejak:</strong> <?= date('d F Y', strtotime($merchantProfile['created_at'])) ?></p>
                <a href="<?= base_url('merchant/profile') ?>" class="btn btn-primary btn-sm">Edit Profil</a>
            </div>
        </div>
    </div>
    
    <!-- Products Stats -->
    <div class="col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Produk</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalProducts ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-box fs-2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Stats -->
    <div class="col-md-4 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Penjualan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($totalSales, 0, ',', '.') ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-currency-dollar fs-2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Low Stock Products -->
    <div class="col-md-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Produk Stok Menipis</h6>
            </div>
            <div class="card-body">
                <?php if (empty($lowStockProducts)): ?>
                    <p class="text-center">Tidak ada produk dengan stok menipis</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lowStockProducts as $product): ?>
                                    <tr>
                                        <td><?= $product['name'] ?></td>
                                        <td>
                                            <span class="badge bg-danger"><?= $product['stock'] ?></span>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('merchant/products/edit/' . $product['id']) ?>" class="btn btn-sm btn-primary">Update</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="col-md-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Pesanan Terbaru</h6>
            </div>
            <div class="card-body">
                <?php if (empty($recentOrders)): ?>
                    <p class="text-center">Belum ada pesanan masuk</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pelanggan</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentOrders as $order): ?>
                                    <tr>
                                        <td><a href="<?= base_url('merchant/orders/detail/' . $order['id']) ?>">#<?= $order['id'] ?></a></td>
                                        <td><?= $order['user_name'] ?></td>
                                        <td>
                                            <?php if ($order['status'] == 'pending'): ?>
                                                <span class="badge bg-warning">Menunggu</span>
                                            <?php elseif ($order['status'] == 'paid'): ?>
                                                <span class="badge bg-info">Dibayar</span>
                                            <?php elseif ($order['status'] == 'shipped'): ?>
                                                <span class="badge bg-success">Dikirim</span>
                                            <?php elseif ($order['status'] == 'cancelled'): ?>
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
                <div class="text-center mt-3">
                    <a href="<?= base_url('merchant/orders') ?>" class="btn btn-primary btn-sm">Lihat Semua Pesanan</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3 text-center">
                        <a href="<?= base_url('merchant/products/create') ?>" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-plus-circle"></i> Tambah Produk
                        </a>
                    </div>
                    <div class="col-md-4 mb-3 text-center">
                        <a href="<?= base_url('merchant/orders') ?>" class="btn btn-info btn-lg w-100">
                            <i class="bi bi-bag"></i> Kelola Pesanan
                        </a>
                    </div>
                    <div class="col-md-4 mb-3 text-center">
                        <a href="<?= base_url('merchant/stats') ?>" class="btn btn-success btn-lg w-100">
                            <i class="bi bi-bar-chart"></i> Lihat Statistik
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>