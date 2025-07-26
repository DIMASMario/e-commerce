<?php
<?= $this->extend('layouts/user') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detail Pesanan #<?= $order->id ?></h1>
        <a href="<?= base_url('user/orders') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="row">
        <!-- Informasi Pesanan -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Pesanan</h5>
                </div>
                <div class="card-body">
                    <p><strong>No. Invoice:</strong> <?= $order->invoice_number ?></p>
                    <p><strong>Status:</strong> 
                        <span class="badge <?= getStatusBadgeClass($order->status) ?>">
                            <?= formatStatus($order->status) ?>
                        </span>
                    </p>
                    <p><strong>Tanggal Pesanan:</strong> <?= date('d M Y H:i', strtotime($order->created_at)) ?></p>
                    <p><strong>Total Pesanan:</strong> Rp <?= number_format($order->total_price, 0, ',', '.') ?></p>
                    <p><strong>Metode Pembayaran:</strong> <?= $order->payment_method ?></p>
                </div>
            </div>
        </div>

        <!-- Informasi Pengiriman -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nama Penerima:</strong> <?= $order->name ?></p>
                    <p><strong>Alamat:</strong> <?= $order->address ?></p>
                    <p><strong>Kota:</strong> <?= $order->city ?></p>
                    <p><strong>Kode Pos:</strong> <?= $order->postal_code ?></p>
                    <p><strong>No. Telepon:</strong> <?= $order->phone ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Barang -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Detail Barang</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($items as $item): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if(!empty($item->image)): ?>
                                    <img src="<?= base_url('uploads/products/' . $item->image) ?>" class="me-3" alt="<?= $item->product_name ?>" width="50">
                                    <?php else: ?>
                                    <div class="bg-light me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-image text-secondary"></i>
                                    </div>
                                    <?php endif; ?>
                                    <span><?= $item->product_name ?></span>
                                </div>
                            </td>
                            <td>Rp <?= number_format($item->price, 0, ',', '.') ?></td>
                            <td><?= $item->quantity ?></td>
                            <td>Rp <?= number_format($item->price * $item->quantity, 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total</strong></td>
                            <td><strong>Rp <?= number_format($order->total_price, 0, ',', '.') ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Status History & Actions -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Riwayat Status</h5>
                </div>
                <div class="card-body">
                    <!-- Status timeline akan ditambahkan di sini jika Anda memiliki fitur riwayat status -->
                    <p class="mb-0 text-muted">Belum ada riwayat status</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tindakan</h5>
                </div>
                <div class="card-body">
                    <?php if($order->status == 'waiting_payment'): ?>
                    <a href="<?= base_url('user/payments/add/' . $order->id) ?>" class="btn btn-success mb-2">
                        <i class="bi bi-credit-card"></i> Bayar Sekarang
                    </a>
                    <a href="<?= base_url('user/orders/cancel/' . $order->id) ?>" class="btn btn-danger mb-2" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                        <i class="bi bi-x-circle"></i> Batalkan Pesanan
                    </a>
                    <?php elseif($order->status == 'shipped'): ?>
                    <a href="<?= base_url('user/orders/confirm-delivery/' . $order->id) ?>" class="btn btn-success mb-2" onclick="return confirm('Konfirmasi bahwa pesanan telah diterima?')">
                        <i class="bi bi-check-circle"></i> Pesanan Diterima
                    </a>
                    <?php elseif($order->status == 'delivered'): ?>
                    <a href="<?= base_url('user/orders/complete/' . $order->id) ?>" class="btn btn-success mb-2">
                        <i class="bi bi-check-circle"></i> Selesaikan Pesanan
                    </a>
                    <?php elseif($order->status == 'completed'): ?>
                    <a href="<?= base_url('products/review/' . $order->id) ?>" class="btn btn-primary mb-2">
                        <i class="bi bi-star"></i> Beri Ulasan
                    </a>
                    <?php endif; ?>
                    
                    <a href="<?= base_url('user/orders/invoice/' . $order->id) ?>" class="btn btn-info mb-2" target="_blank">
                        <i class="bi bi-file-earmark-text"></i> Lihat Invoice
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Helper functions
function getStatusBadgeClass($status) {
    $classes = [
        'waiting_payment' => 'bg-warning',
        'paid' => 'bg-info',
        'processing' => 'bg-primary',
        'shipped' => 'bg-info',
        'delivered' => 'bg-success',
        'completed' => 'bg-success',
        'cancelled' => 'bg-danger'
    ];
    return $classes[$status] ?? 'bg-secondary';
}

function formatStatus($status) {
    $labels = [
        'waiting_payment' => 'Menunggu Pembayaran',
        'paid' => 'Dibayar',
        'processing' => 'Diproses',
        'shipped' => 'Dikirim',
        'delivered' => 'Diterima',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan'
    ];
    return $labels[$status] ?? ucfirst($status);
}
?>
<?= $this->endSection() ?>