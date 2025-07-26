<?php
$this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="mb-4">
        <h1><?= esc($category['name']) ?></h1>
        <?php if (isset($category['description']) && !empty($category['description'])): ?>
            <p class="lead"><?= esc($category['description']) ?></p>
        <?php endif; ?>
    </div>
    
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        <?php if (empty($products)): ?>
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Belum ada produk dalam kategori ini.
                </div>
            </div>
        <?php else: ?>
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
                            <div class="mt-2 product-description">
                                <?php if (isset($product['description']) && !empty($product['description'])): ?>
                                    <?= mb_substr(esc($product['description']), 0, 80) . (strlen($product['description']) > 80 ? '...' : '') ?>
                                <?php else: ?>
                                    Tidak ada deskripsi
                                <?php endif; ?>
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
        <?php endif; ?>
    </div>
</div>

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