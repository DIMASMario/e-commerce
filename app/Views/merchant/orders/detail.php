<?php
<?= $this->extend('layouts/merchant') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Detail Pesanan #<?= $order['id'] ?></h1>
    <a href="<?= base_url('merchant/orders') ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pesanan
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row">
    <!-- Order Information -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Informasi Pesanan</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="35%">ID Pesanan</th>
                        <td>#<?= $order['id'] ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <?php if ($order['status'] == 'pending'): ?>
                                <span class="badge bg-warning">Menunggu Pembayaran</span>
                            <?php elseif ($order['status'] == 'paid'): ?>
                                <span class="badge bg-info">Dibayar</span>
                            <?php elseif ($order['status'] == 'shipped'): ?>
                                <span class="badge bg-success">Dikirim</span>
                            <?php elseif ($order['status'] == 'cancelled'): ?>
                                <span class="badge bg-danger">Dibatalkan</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Pesanan</th>
                        <td><?= date('d F Y, H:i', strtotime($order['created_at'])) ?></td>
                    </tr>
                    <tr>
                        <th>Pelanggan</th>
                        <td><?= $order['user']['name'] ?></td>
                    </tr>
                </table>
                
                <?php if ($order['status'] == 'paid'): ?>
                    <form action="<?= base_url('merchant/orders/updateStatus/' . $order['id']) ?>" method="post">
                        <input type="hidden" name="status" value="shipped">
                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('Apakah Anda yakin ingin mengubah status pesanan menjadi Dikirim?')">
                            <i class="bi bi-truck"></i> Tandai sebagai Dikirim
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Payment Information -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Informasi Pembayaran</h5>
            </div>
            <div class="card-body">
                <?php if (empty($order['payment'])): ?>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle-fill"></i> Pelanggan belum melakukan pembayaran
                    </div>
                <?php else: ?>
                    <table class="table table-borderless">
                        <tr>
                            <th width="35%">Status Pembayaran</th>
                            <td>
                                <?php if ($order['payment']['status'] == 'waiting'): ?>
                                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                                <?php elseif ($order['payment']['status'] == 'verified'): ?>
                                    <span class="badge bg-success">Terverifikasi</span>
                                <?php elseif ($order['payment']['status'] == 'rejected'): ?>
                                    <span class="badge bg-danger">Ditolak</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Pembayaran</th>
                            <td><?= date('d F Y, H:i', strtotime($order['payment']['created_at'])) ?></td>
                        </tr>
                        <tr>
                            <th>Bukti Pembayaran</th>
                            <td>
                                <a href="<?= base_url('uploads/payments/' . $order['payment']['payment_proof']) ?>" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="bi bi-image"></i> Lihat Bukti
                                </a>
                            </td>
                        </tr>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Order Items -->
<div class="card shadow mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Produk dalam Pesanan (Hanya Produk Anda)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th width="15%">Harga</th>
                        <th width="10%">Jumlah</th>
                        <th width="15%">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $merchantTotal = 0;
                        foreach ($orderDetails as $item): 
                        $subtotal = $item['price'] * $item['quantity'];
                        $merchantTotal += $subtotal;
                    ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url('uploads/products/' . $item['image']) ?>" alt="<?= $item['name'] ?>" class="img-thumbnail me-3" style="width: 60px;">
                                    <div>
                                        <h6 class="mb-0"><?= $item['name'] ?></h6>
                                    </div>
                                </div>
                            </td>
                            <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total (Produk Anda)</th>
                        <th>Rp <?= number_format($merchantTotal, 0, ',', '.') ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>