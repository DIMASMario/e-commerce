<?php
$this->extend('layouts/admin');

$this->section('content');
?>

<div class="row">
    <!-- Users Stats -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Pengguna</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalUsers ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people fs-2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Stats -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Pesanan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalOrders ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-bag fs-2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Stats -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
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
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Pendapatan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($totalRevenue, 0, ',', '.') ?></div>
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
    <!-- Pending Payments Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Pembayaran Menunggu</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pendingPayments ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-credit-card fs-2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Merchants Stats -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Total Merchant</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalMerchants ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-shop fs-2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Orders -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Pesanan Tertunda</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pendingOrders ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-hourglass-split fs-2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shipped Orders -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Pesanan Dikirim</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $shippedOrders ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-truck fs-2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Orders -->
    <div class="col-md-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Pesanan Terbaru</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentOrders as $order): ?>
                                <tr>
                                    <td><a href="<?= base_url('admin/orders/detail/' . $order['id']) ?>">#<?= $order['id'] ?></a></td>
                                    <td><?= $order['user_name'] ?></td>
                                    <td>Rp <?= number_format($order['total_price'], 0, ',', '.') ?></td>
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
                <div class="text-center mt-3">
                    <a href="<?= base_url('admin/orders') ?>" class="btn btn-primary btn-sm">Lihat Semua Pesanan</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="col-md-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Pembayaran Terbaru</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentPayments as $payment): ?>
                                <tr>
                                    <td><a href="<?= base_url('admin/payments/detail/' . $payment['id']) ?>">#<?= $payment['id'] ?></a></td>
                                    <td><?= $payment['user_name'] ?></td>
                                    <td>Rp <?= number_format($payment['total_price'], 0, ',', '.') ?></td>
                                    <td>
                                        <?php if ($payment['status'] == 'waiting'): ?>
                                            <span class="badge bg-warning">Menunggu</span>
                                        <?php elseif ($payment['status'] == 'verified'): ?>
                                            <span class="badge bg-success">Terverifikasi</span>
                                        <?php elseif ($payment['status'] == 'rejected'): ?>
                                            <span class="badge bg-danger">Ditolak</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($payment['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="<?= base_url('admin/payments') ?>" class="btn btn-primary btn-sm">Lihat Semua Pembayaran</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>