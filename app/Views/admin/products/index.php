<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1 class="mb-4">Kelola Produk</h1>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="mb-3">
        <a href="<?= base_url('admin/products/create') ?>" class="btn btn-primary">Tambah Produk</a>
    </div>

    <div class="row">
        <?php if (!empty($products)) : ?>
            <?php foreach ($products as $product) : ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm product-card">
                        <a href="<?= base_url('product/' . $product['id']) ?>">
                            <img src="<?= base_url('uploads/products/' . $product['image']) ?>" class="card-img-top" alt="<?= esc($product['name']) ?>">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= esc($product['name']) ?></h5>
                            <p class="card-text text-muted small"><?= esc($product['category_name']) ?></p>
                            <h6 class="card-subtitle mb-2 text-danger">Rp <?= number_format($product['price'], 0, ',', '.') ?></h6>
                            
                            <!-- PASTIKAN FORM INI ADA DI SINI -->
                            <form action="<?= base_url('cart/add') ?>" method="post" class="mt-auto">
                                <?= csrf_field() ?>
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="quantity" value="1">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-outline-primary">
                                        Tambah ke Keranjang
                                    </button>
                                </div>
                            </form>
                            <!-- AKHIR FORM -->

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col">
                <p class="text-center">Tidak ada produk yang ditemukan.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
