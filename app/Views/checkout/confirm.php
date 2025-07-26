<?php
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h2>Pesanan Berhasil Dibuat!</h2>
                    <p class="mb-4">Nomor Order: <strong>#<?= $order['id'] ?></strong></p>
                    <div class="alert alert-info mb-4">
                        <h5>Langkah Selanjutnya:</h5>
                        <p>Silakan lakukan pembayaran sejumlah <strong>Rp <?= number_format($order['total_price'], 0, ',', '.') ?></strong> melalui transfer bank.</p>
                        <p class="mb-0">Setelah melakukan pembayaran, Anda perlu mengupload bukti transfer agar pesanan Anda diproses.</p>
                    </div>
                    
                    <div class="mb-4">
                        <table class="table table-bordered">
                            <tr>
                                <th>Total Pembayaran</th>
                                <td class="text-primary fw-bold">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><span class="badge bg-warning">Menunggu Pembayaran</span></td>
                            </tr>
                            <tr>
                                <th>Waktu Pesanan</th>
                                <td><?= date('d F Y, H:i', strtotime($order['created_at'])) ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div>
                        <a href="<?= base_url('payment/' . $order['id']) ?>" class="btn btn-primary btn-lg">
                            <i class="bi bi-credit-card"></i> Lanjutkan ke Pembayaran
                        </a>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex justify-content-center gap-2">
                        <a href="<?= base_url('user/orders') ?>" class="btn btn-outline-primary">
                            <i class="bi bi-bag"></i> Lihat Pesanan Saya
                        </a>
                        <a href="<?= base_url() ?>" class="btn btn-success">
                            <i class="bi bi-house"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>