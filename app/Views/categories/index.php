<?php
$this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <h1 class="mb-4"><?= $title ?></h1>
    
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        <?php foreach ($categories as $category): ?>
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= esc($category['name']) ?></h5>
                        <p class="card-text"><?= esc($category['description'] ?? 'Tidak ada deskripsi') ?></p>
                    </div>
                    <div class="card-footer">
                        <a href="<?= base_url('categories/' . $category['id']) ?>" class="btn btn-primary">Lihat Produk</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>