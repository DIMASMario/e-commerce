<?php $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('products') ?>">Produk</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($product['name']) ?></li>
        </ol>
    </nav>
    
    <div class="row g-5">
        <!-- Gambar Produk -->
        <div class="col-md-5">
            <div class="card border-0">
                <img src="<?= base_url('uploads/products/' . $product['image']) ?>" class="img-fluid rounded" alt="<?= esc($product['name']) ?>">
            </div>
        </div>
        
        <!-- Detail Produk -->
        <div class="col-md-7">
            <h1 class="mb-3"><?= esc($product['name']) ?></h1>
            <p class="text-muted">Kategori: <span class="badge bg-secondary"><?= esc($product['category_name']) ?></span></p>
            <div class="fs-4 mb-4 text-danger">Rp <?= number_format($product['price'], 0, ',', '.') ?></div>
            
            <div class="mb-4">
                <h5>Deskripsi Produk</h5>
                <p><?= nl2br(esc($product['description'])) ?></p>
            </div>
            
            <div class="mb-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0">Stok: <?= $product['stock'] > 0 ? $product['stock'] : 'Habis' ?></h5>
                        <?php if ($product['stock'] <= 0): ?>
                            <div class="text-danger">Produk tidak tersedia</div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <?php if (isset($merchant['shop_name'])): ?>
                            <p class="mb-0">Dijual oleh: <strong><?= esc($merchant['shop_name']) ?></strong></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <?php if ($product['stock'] > 0): ?>
                <div class="mb-4">
                    <?php if (session()->get('isLoggedIn')): ?>
                        <form action="<?= base_url('cart/add') ?>" method="post" class="mb-3">
                            <?= csrf_field() ?>
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <label for="quantity" class="form-label">Jumlah:</label>
                                </div>
                                <div class="col-auto">
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>">
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2 mt-3">
                                <!-- Tombol Tambah ke Keranjang -->
                                <button type="submit" class="btn btn-outline-primary btn-lg">
                                    <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                                </button>
                                
                                <!-- Tombol Beli Sekarang -->
                                <button type="submit" class="btn btn-primary btn-lg" name="buy_now" value="1">
                                    <i class="bi bi-lightning"></i> Beli Sekarang
                                </button>
                            </div>
                        </form>
                        
                        <div class="mt-2">
                            <?php if ($isInWishlist): ?>
                                <button disabled class="btn btn-outline-danger">
                                    <i class="bi bi-heart-fill"></i> Dalam Wishlist
                                </button>
                            <?php else: ?>
                                <form action="<?= base_url('user/wishlist/add/' . $product['id']) ?>" method="post">
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="bi bi-heart"></i> Tambah ke Wishlist
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Silakan <a href="<?= base_url('auth/login') ?>">login</a> untuk membeli produk ini.
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-12">
            <h3>Produk Terkait</h3>
            <hr>
        </div>
        
        <?php if (empty($relatedProducts)): ?>
            <div class="col-12">
                <p>Tidak ada produk terkait.</p>
            </div>
        <?php else: ?>
            <?php foreach ($relatedProducts as $relatedProduct): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="<?= base_url('uploads/products/' . $relatedProduct['image']) ?>" class="card-img-top" alt="<?= $relatedProduct['name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $relatedProduct['name'] ?></h5>
                            <p class="card-text fw-bold text-primary">Rp <?= number_format($relatedProduct['price'], 0, ',', '.') ?></p>
                            <a href="<?= base_url('products/' . $relatedProduct['id']) ?>" class="btn btn-sm btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>