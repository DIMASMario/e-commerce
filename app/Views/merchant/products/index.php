<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col">
            <h1>Semua Produk Kaos Kaki</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Produk</li>
                </ol>
            </nav>
        </div>
        <div class="col-auto">
            <a href="<?= base_url('merchant/products/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Produk Baru
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if (empty($products)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-box text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3">Belum Ada Produk</h4>
                    <p class="text-muted">Anda belum menambahkan produk apa pun ke toko Anda.</p>
                    <a href="<?= base_url('merchant/products/create') ?>" class="btn btn-primary mt-2">
                        <i class="bi bi-plus-circle"></i> Tambah Produk Baru
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover" id="productsTable">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td>
                                        <img src="<?= base_url('uploads/products/' . $product['image']) ?>" alt="<?= $product['name'] ?>" class="img-thumbnail" style="width: 80px;">
                                    </td>
                                    <td><?= $product['name'] ?></td>
                                    <td><?= $product['category_name'] ?></td>
                                    <td>Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                                    <td><?= $product['stock'] ?></td>
                                    <td>
                                        <?php if ($product['stock'] > 10): ?>
                                            <span class="badge bg-success">Tersedia</span>
                                        <?php elseif ($product['stock'] > 0): ?>
                                            <span class="badge bg-warning">Stok Menipis</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Habis</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= base_url('products/' . $product['id']) ?>" class="btn btn-sm btn-info" target="_blank">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('merchant/products/edit/' . $product['id']) ?>" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="<?= base_url('merchant/products/delete/' . $product['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTables
        if (document.getElementById('productsTable')) {
            $('#productsTable').DataTable();
        }
    });
    </script>
</div>

<?= $this->endSection() ?>