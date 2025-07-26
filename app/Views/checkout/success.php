<?php $this->extend('layouts/main') ?>

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
                    <?php if(isset($order['invoice_number'])): ?>
                    <p class="mb-4">Nomor Invoice: <strong><?= $order['invoice_number'] ?></strong></p>
                    <?php else: ?>
                    <p class="mb-4">Nomor Pesanan: <strong>#<?= str_pad($order['id'], 4, '0', STR_PAD_LEFT) ?></strong></p>
                    <?php endif; ?>
                    
                    <div class="alert alert-success mb-4">
                        <h5>Terima Kasih!</h5>
                        <p>Pesanan Anda telah kami terima dan bukti pembayaran Anda sedang dalam proses verifikasi.</p>
                        <p class="mb-0">Kami akan segera memproses pesanan Anda setelah pembayaran terverifikasi.</p>
                    </div>
                    
                    <div class="mb-4">
                        <table class="table table-bordered">
                            <tr>
                                <th>Total Pembayaran</th>
                                <td class="text-primary fw-bold">
                                    <?php 
                                    // Ambil total dari order_details jika tidak ada di order
                                    $totalAmount = 0;
                                    
                                    if (isset($order['total_amount']) && $order['total_amount'] > 0) {
                                        $totalAmount = $order['total_amount'];
                                    } else if (isset($order['total_price']) && $order['total_price'] > 0) {
                                        $totalAmount = $order['total_price'];
                                    }
                                    ?>
                                    Rp <?= number_format($totalAmount, 0, ',', '.') ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><span class="badge bg-info">Menunggu Verifikasi Pembayaran</span></td>
                            </tr>
                            <tr>
                                <th>Waktu Pesanan</th>
                                <td><?= date('d F Y, H:i', strtotime($order['created_at'])) ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex justify-content-center gap-3">
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