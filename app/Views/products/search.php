<?php
helper('text');
$this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Hasil Pencarian: "<?= esc($keyword) ?>"</h1>
            <p class="text-muted">Ditemukan <?= count($products) ?> produk</p>
        </div>
        <div class="col-md-4">
            <form action="<?= base_url('products/search') ?>" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari produk..." name="keyword" value="<?= esc($keyword) ?>">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php if (empty($products)): ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Tidak ada produk yang sesuai dengan kata kunci "<?= esc($keyword) ?>". Coba kata kunci lain atau lihat <a href="<?= base_url('products') ?>">semua produk</a>.
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($products as $product): ?>
                <div class="col">
                    <div class="card h-100 product-card">
                        <?php if (!empty($product['image'])): ?>
                            <img src="<?= base_url('uploads/products/' . $product['image']) ?>" class="card-img-top product-img" alt="<?= esc($product['name']) ?>">
                        <?php else: ?>
                            <img src="<?= base_url('assets/images/no-image.jpg') ?>" class="card-img-top product-img" alt="No Image">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($product['name']) ?></h5>
                            <p class="card-text text-primary fw-bold">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                            <?php if (isset($product['category_name'])): ?>
                                <span class="badge bg-secondary"><?= esc($product['category_name']) ?></span>
                            <?php endif; ?>
                            <div class="mt-2 product-description">
                                <?= character_limiter($product['description'] ?? 'Tidak ada deskripsi', 80) ?>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <a href="<?= base_url('products/' . $product['id']) ?>" class="btn btn-sm btn-outline-secondary">Detail</a>
                            <form action="<?= base_url('cart/add') ?>" method="post">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="bi bi-cart-plus"></i> Tambah
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .product-img {
        height: 200px;
        object-fit: cover;
    }
    
    .product-description {
        font-size: 0.9rem;
        color: #6c757d;
        height: 60px;
        overflow: hidden;
    }
    
    .product-card {
        transition: transform 0.3s;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,.1);
    }
</style>
<?= $this->endSection() ?>