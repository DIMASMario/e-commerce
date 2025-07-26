<?php
$this->extend('layouts/main') ?>

<?php $this->section('content') ?>
    <div class="container">
        <h1>Selamat Datang di Sockincek</h1>
        <p>Toko online kaos kaki terlengkap.</p>
        <a href="<?= base_url('products') ?>" class="btn btn-primary">Lihat Semua Produk</a>
    </div>
<?php $this->endSection() ?>