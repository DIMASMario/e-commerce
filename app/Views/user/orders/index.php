<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h2>Pesanan Saya</h2>
    <?php if (!empty($orders)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= esc($order->invoice_number) ?></td>
                    <td><?= date('d-m-Y', strtotime($order->created_at)) ?></td>
                    <td>
                        <?php if($order->status == 'waiting_payment'): ?>
                            <span class="badge bg-warning">Menunggu Pembayaran</span>
                        <?php elseif($order->status == 'paid'): ?>
                            <span class="badge bg-info">Dibayar</span>
                        <?php elseif($order->status == 'processing'): ?>
                            <span class="badge bg-primary">Diproses</span>
                        <?php elseif($order->status == 'shipped'): ?>
                            <span class="badge bg-info">Dikirim</span>
                        <?php elseif($order->status == 'delivered'): ?>
                            <span class="badge bg-success">Diterima</span>
                        <?php elseif($order->status == 'completed'): ?>
                            <span class="badge bg-success">Selesai</span>
                        <?php elseif($order->status == 'cancelled'): ?>
                            <span class="badge bg-danger">Dibatalkan</span>
                        <?php else: ?>
                            <span class="badge bg-secondary"><?= ucfirst($order->status) ?></span>
                        <?php endif; ?>
                    </td>
                    <td>Rp <?= number_format($order->total_price, 0, ',', '.') ?></td>
                    <td>
                        <a href="<?= base_url('user/orders/detail/' . $order->id) ?>" class="btn btn-sm btn-primary">Detail</a>
                        
                        <?php if($order->status == 'waiting_payment'): ?>
                            <a href="<?= base_url('user/payments/add/' . $order->id) ?>" class="btn btn-sm btn-success">Bayar</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Anda belum memiliki pesanan.</p>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
