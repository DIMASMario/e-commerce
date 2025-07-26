<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <h1 class="mb-4">Semua Produk Kaos Kaki</h1>
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active">Produk</li>
        </ol>
    </nav>

    <!-- Filter Produk -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Filter Produk</h5>
                </div>
                <div class="card-body">
                    <h6>Kategori</h6>
                    <div class="list-group">
                        <a href="<?= base_url('products') ?>" class="list-group-item list-group-item-action active">
                            Semua Kategori
                        </a>
                        <?php foreach ($categories as $category): ?>
                            <a href="<?= base_url('products/category/' . $category['id']) ?>" class="list-group-item list-group-item-action">
                                <?= $category['name'] ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <!-- Pencarian Produk -->
            <div class="mb-3">
                <form action="<?= base_url('products/search') ?>" method="get" class="d-flex">
                    <input class="form-control me-2" type="search" name="keyword" placeholder="Cari produk..." aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i> Cari</button>
                </form>
            </div>
            
            <!-- Daftar Produk -->
            <div class="row g-3">
                <?php if (empty($products)): ?>
                    <div class="col-12">
                        <div class="alert alert-info">Tidak ada produk yang ditemukan.</div>
                    </div>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 shadow-sm product-card">
                                <a href="<?= base_url('products/' . $product['id']) ?>">
                                    <img src="<?= base_url('uploads/products/' . $product['image']) ?>" class="card-img-top" alt="<?= esc($product['name']) ?>">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title"><?= esc($product['name']) ?></h5>
                                    <p class="card-text text-muted small"><?= esc($product['category_name']) ?></p>
                                    <h6 class="card-subtitle mb-2 text-danger">Rp <?= number_format($product['price'], 0, ',', '.') ?></h6>
                                    <?php if ($product['stock'] <= 0): ?>
                                        <span class="badge bg-danger mb-2">Stok Habis</span>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer p-2 border-top-0 bg-transparent">
                                    <div class="d-grid gap-2">
                                        <!-- Form untuk Tambah ke Keranjang -->
                                        <form action="<?= base_url('cart/add') ?>" method="post">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                            <input type="hidden" name="quantity" value="1">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-outline-primary" <?= ($product['stock'] <= 0) ? 'disabled' : '' ?>>
                                                    <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                                                </button>
                                            </div>
                                        </form>
                                        
                                        <!-- Form untuk Beli Langsung -->
                                        <form action="<?= base_url('cart/add') ?>" method="post">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="buy_now" value="1">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary" <?= ($product['stock'] <= 0) ? 'disabled' : '' ?>>
                                                    <i class="bi bi-lightning"></i> Beli Sekarang
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center flex-wrap mt-4">
                <div class="me-3">
                    <p class="mb-0">Menampilkan <?= count($products) ?> dari <?= $totalProducts ?> produk</p>
                </div>
                <div>
                    <?= $pager->links() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>