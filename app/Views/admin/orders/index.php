<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= esc($title) ?></h1>

    <?php if (!empty($orders)): ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pengguna</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Tanggal Pesanan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $index => $order): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($order['user_name']) ?></td>
                        <td>Rp <?= number_format($order['total_price'], 0, ',', '.') ?></td>
                        <td><?= esc($order['status']) ?></td>
                        <td><?= date('d M Y H:i', strtotime($order['created_at'])) ?></td>
                        <td>
                            <a href="<?= base_url('admin/orders/detail/' . $order['id']) ?>" class="btn btn-sm btn-primary">Detail</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada data pesanan.</p>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
