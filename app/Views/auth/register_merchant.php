<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Daftar sebagai Penjual</h3>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle-fill"></i> Daftar sebagai penjual untuk mulai menjual produk Anda di Socksin.
                    </div>
                    <form action="<?= base_url('auth/register-merchant') ?>" method="post" novalidate>
                        <div class="mb-3">
                            <label for="shop_name" class="form-label">Nama Toko</label>
                            <input type="text" class="form-control" id="shop_name" name="shop_name" value="<?= old('shop_name') ?>" required>
                            <?php if(isset($errors['shop_name'])): ?>
                                <div class="text-danger"><?= $errors['shop_name'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required><?= old('address') ?></textarea>
                            <?php if(isset($errors['address'])): ?>
                                <div class="text-danger"><?= $errors['address'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="contact" class="form-label">Kontak</label>
                            <input type="text" class="form-control" id="contact" name="contact" value="<?= old('contact') ?>" required>
                            <?php if(isset($errors['contact'])): ?>
                                <div class="text-danger"><?= $errors['contact'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" value="1" required>
                            <label class="form-check-label" for="terms">Saya setuju dengan syarat dan ketentuan</label>
                            <?php if(isset($errors['terms'])): ?>
                                <div class="text-danger"><?= $errors['terms'] ?></div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Daftar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
