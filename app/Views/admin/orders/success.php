<?php
// filepath: app/Views/order/success.php
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Pesanan Berhasil Dibuat!</h4>
                </div>
                <div class="card-body">
                    <p>Terima kasih. Pesanan Anda dengan nomor <strong>#<?= esc($order['invoice_number']) ?></strong> telah kami terima.</p>
                    <p>Total yang harus dibayar: <strong class="text-danger fs-5">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></strong></p>
                    <hr>
                    <h5>Langkah Selanjutnya:</h5>
                    <ol>
                        <li>Silakan lakukan transfer ke salah satu rekening berikut:
                            <ul>
                                <li><strong>Bank BCA:</strong> 123456789 (a.n. PT Socksin Indonesia)</li>
                                <li><strong>Bank Mandiri:</strong> 987654321 (a.n. PT Socksin Indonesia)</li>
                            </ul>
                        </li>
                        <li>Unggah bukti pembayaran Anda pada form di bawah ini.</li>
                    </ol>
                    <hr>

                    <h5>Unggah Bukti Pembayaran</h5>

                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>
                    <?php if (session()->has('errors')) : ?>
                        <div class="alert alert-danger">
                            <?php foreach (session('errors') as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('order/upload_proof') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="order_id" value="<?= esc($order['id']) ?>">
                        <div class="mb-3">
                            <label for="payment_proof" class="form-label">Pilih file gambar:</label>
                            <input class="form-control" type="file" id="payment_proof" name="payment_proof" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Unggah Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>