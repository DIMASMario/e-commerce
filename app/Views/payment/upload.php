<?php
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col">
            <h1>Upload Bukti Pembayaran</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('user/orders') ?>">Pesanan Saya</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Upload Pembayaran</li>
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

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Upload Bukti Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <h5 class="mb-3">Detail Pesanan:</h5>
                        <table class="table table-sm mb-0">
                            <tr>
                                <td width="150">ID Pesanan</td>
                                <td><strong>#<?= $order['id'] ?></strong></td>
                            </tr>
                            <tr>
                                <td>Total Pembayaran</td>
                                <td class="text-primary fw-bold">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td><span class="badge bg-warning">Menunggu Pembayaran</span></td>
                            </tr>
                        </table>
                    </div>
                    
                    <h5 class="mb-3">Langkah-langkah Pembayaran:</h5>
                    <ol>
                        <li>Transfer sejumlah <strong>Rp <?= number_format($order['total_price'], 0, ',', '.') ?></strong> ke salah satu rekening di atas.</li>
                        <li>Simpan bukti transfer dalam bentuk foto atau screenshot.</li>
                        <li>Upload bukti transfer pada formulir di bawah.</li>
                        <li>Klik tombol "Kirim Bukti Pembayaran".</li>
                        <li>Tunggu konfirmasi dari admin (biasanya 1x24 jam).</li>
                    </ol>
                    
                    <div class="mt-4">
                        <form action="<?= base_url('payment/upload/' . $order['id']) ?>" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="payment_proof" class="form-label">Upload Bukti Pembayaran</label>
                                <input class="form-control" type="file" id="payment_proof" name="payment_proof" accept="image/*" required>
                                <div class="form-text">Format: JPG, JPEG, PNG (Maks. 2MB)</div>
                            </div>
                            
                            <div class="text-center mb-3">
                                <img id="previewImage" class="img-thumbnail d-none" style="max-height: 300px;">
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a href="<?= base_url('user/orders/detail/' . $order['id']) ?>" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-upload"></i> Kirim Bukti Pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Rekening Tujuan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title">BCA</h6>
                                    <p class="card-text mb-1">8720384935</p>
                                    <p class="card-text"><small class="text-muted">a/n PT SOCKSIN INDONESIA</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title">BNI</h6>
                                    <p class="card-text mb-1">0954283751</p>
                                    <p class="card-text"><small class="text-muted">a/n PT SOCKSIN INDONESIA</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title">Mandiri</h6>
                                    <p class="card-text mb-1">1370085429364</p>
                                    <p class="card-text"><small class="text-muted">a/n PT SOCKSIN INDONESIA</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
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