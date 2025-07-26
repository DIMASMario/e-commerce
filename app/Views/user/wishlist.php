<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col">
            <h1>Wishlist Saya</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('user/dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                </ol>
            </nav>
        </div>
    </div>

    <?php if (!empty($wishlistItems)): ?>
        <div class="row">
            <?php foreach ($wishlistItems as $item): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="<?= base_url('uploads/products/' . $item['image']) ?>" class="card-img-top" alt="<?= esc($item['name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($item['name']) ?></h5>
                            <p class="card-text">Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                            <a href="<?= base_url('user/wishlist/remove/' . $item['id']) ?>" class="btn btn-danger btn-sm">Hapus</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Wishlist Anda kosong.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
