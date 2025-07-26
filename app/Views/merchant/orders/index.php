<?php
<?= $this->extend('layouts/merchant') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Daftar Pesanan</h1>
    <a href="<?= base_url('merchant/dashboard') ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
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

<div class="card shadow mb-4">
    <div class="card-body">
        <?php if (empty($orders)): ?>
            <div class="text-center py-5">
                <i class="bi bi-bag text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3">Belum Ada Pesanan</h4>
                <p class="text-muted">Pesanan yang berisi produk Anda akan muncul di sini.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover" id="ordersTable">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Jumlah Item</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>#<?= $order['id'] ?></td>
                                <td><?= $order['user_name'] ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                <td><?= $order['total_items'] ?></td>
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
                                <td>
                                    <a href="<?= base_url('merchant/orders/detail/' . $order['id']) ?>" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable for sorting and searching
    $('#ordersTable').DataTable({
        "order": [[ 2, "desc" ]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
        }
    });
});
</script>

<?= $this->endSection() ?>