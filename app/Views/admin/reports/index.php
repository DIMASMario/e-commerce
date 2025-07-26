<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= esc($title) ?></h1>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Pesanan</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $totalOrders ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Pembayaran</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $totalPayments ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Total Pengguna</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $totalUsers ?></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h3>Detail Pesanan Terbaru</h3>
        <?php if (!empty($recentOrders)): ?>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Pengguna</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Tanggal Pesanan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentOrders as $index => $order): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= esc($order['user_name']) ?></td>
                            <td>Rp <?= number_format($order['total_price'], 0, ',', '.') ?></td>
                            <td><?= esc($order['status']) ?></td>
                            <td><?= date('d M Y H:i', strtotime($order['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Tidak ada data pesanan terbaru.</p>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
