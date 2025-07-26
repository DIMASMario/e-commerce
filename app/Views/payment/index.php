<?php
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col">
            <h1>Pembayaran Pesanan</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('user/orders') ?>">Pesanan Saya</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
                </ol>
            </nav>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->has('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <p><strong>Total Pembayaran:</strong> <span class="text-primary fw-bold">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></span></p>
                    
                    <div class="alert alert-info">
                        <h6><i class="bi bi-info-circle"></i> Instruksi Pembayaran:</h6>
                        <ol class="mb-0">
                            <li>Transfer sesuai nominal di atas ke salah satu rekening berikut</li>
                            <li>Pastikan transfer tepat hingga digit terakhir</li>
                            <li>Upload bukti transfer pada form di samping</li>
                            <li>Admin akan memverifikasi pembayaran Anda</li>
                        </ol>
                    </div>
                    
                    <h5 class="mt-4 mb-3">Rekening Tujuan:</h5>
                    <div class="row">
                        <?php foreach ($bankAccounts as $bank): ?>
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title"><?= $bank['bank'] ?></h6>
                                        <p class="card-text mb-1"><?= $bank['account_number'] ?></p>
                                        <p class="card-text"><small class="text-muted">a/n <?= $bank['account_name'] ?></small></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Upload Bukti Bayar</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('payment/upload/' . $order['id']) ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="payment_proof" class="form-label">Bukti Pembayaran</label>
                            <input class="form-control" type="file" id="payment_proof" name="payment_proof" accept="image/*" required>
                            <div class="form-text">Format: JPG, JPEG, PNG (Maks. 2MB)</div>
                        </div>
                        
                        <div class="text-center mb-3">
                            <img id="previewImage" class="img-thumbnail d-none" style="max-height: 200px;">
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Upload Bukti Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Pesanan</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td>ID Pesanan</td>
                            <td><strong>#<?= $order['id'] ?></strong></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                <span class="badge bg-warning">Menunggu Pembayaran</span>
                            </td>
                        </tr>
                    </table>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Pembayaran</span>
                        <span class="fw-bold fs-5">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Bantuan</h5>
                </div>
                <div class="card-body">
                    <p>Jika Anda memiliki pertanyaan atau mengalami kesulitan dalam melakukan pembayaran, silakan hubungi kami:</p>
                    <p><i class="bi bi-envelope-fill"></i> Email: <a href="mailto:support@socksin.com">support@socksin.com</a></p>
                    <p><i class="bi bi-whatsapp"></i> WhatsApp: <a href="https://wa.me/6281234567890">0812-3456-7890</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('payment_proof').addEventListener('change', function(e) {
    var preview = document.getElementById('previewImage');
    preview.classList.remove('d-none');
    preview.src = URL.createObjectURL(e.target.files[0]);
    preview.onload = function() {
        URL.revokeObjectURL(preview.src);
    }
});
</script>

<?= $this->endSection() ?>