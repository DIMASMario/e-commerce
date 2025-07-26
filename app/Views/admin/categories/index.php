<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1 class="mb-4">Kelola Kategori</h1>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="mb-3">
        <a href="<?= base_url('admin/categories/create') ?>" class="btn btn-primary">Tambah Kategori</a>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Tanggal Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categories) && is_array($categories)): ?>
                <?php foreach ($categories as $index => $category): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($category['name']) ?></td>
                        <td><?= esc($category['description'] ?? '-') ?></td>
                        <td><?= isset($category['created_at']) ? date('d M Y H:i', strtotime($category['created_at'])) : '-' ?></td>
                        <td>
                            <a href="<?= base_url('admin/categories/edit/' . $category['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= base_url('admin/categories/delete/' . $category['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data kategori.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
