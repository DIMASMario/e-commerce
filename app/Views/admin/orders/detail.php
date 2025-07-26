<?php $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detail Pesanan #<?= $order->id ?></h1>
        <a href="<?= base_url('admin/orders') ?>" class="btn btn-secondary">
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
                    <p><strong>ID Pesanan:</strong> #<?= $order->id ?></p>
                    <p><strong>Invoice:</strong> <?= $order->invoice_number ?></p>
                    <p><strong>Status:</strong> 
                        <span class="badge <?= getStatusBadgeClass($order->status) ?>">
                            <?= formatStatus($order->status) ?>
                        </span>
                    </p>
                    <p><strong>Tanggal Pesanan:</strong> <?= date('d M Y H:i', strtotime($order->created_at)) ?></p>
                    <p><strong>Total Pesanan:</strong> Rp <?= number_format($order->total_price, 0, ',', '.') ?></p>
                </div>
            </div>
        </div>

        <!-- Informasi Pelanggan -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Informasi Pelanggan</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong> <?= $order->name ?? '-' ?></p>
                    <p><strong>Email:</strong> <?= $order->email ?? '-' ?></p>
                    <p><strong>Telepon:</strong> <?= $order->phone ?? '-' ?></p>
                    <p><strong>Alamat:</strong> <?= $order->address ?? '-' ?></p>
                    <p><strong>Kota:</strong> <?= $order->city ?? '-' ?></p>
                    <p><strong>Kode Pos:</strong> <?= $order->postal_code ?? '-' ?></p>
                    <p><strong>Metode Pembayaran:</strong> <?= $order->payment_method ?? '-' ?></p>
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

    <!-- Tindakan -->
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Tindakan</h5>
        </div>
        <div class="card-body">
            <h6>Ubah Status</h6>
            <form id="updateStatusForm" action="<?= base_url('admin/orders/update-status') ?>" method="post" class="d-flex">
                <input type="hidden" name="id" value="<?= $order->id ?>">
                <select name="status" class="form-select me-2" required>
                    <option value="">Pilih Status</option>
                    <option value="waiting_payment" <?= $order->status == 'waiting_payment' ? 'selected' : '' ?>>Menunggu Pembayaran</option>
                    <option value="paid" <?= $order->status == 'paid' ? 'selected' : '' ?>>Dibayar</option>
                    <option value="processing" <?= $order->status == 'processing' ? 'selected' : '' ?>>Diproses</option>
                    <option value="shipped" <?= $order->status == 'shipped' ? 'selected' : '' ?>>Dikirim</option>
                    <option value="delivered" <?= $order->status == 'delivered' ? 'selected' : '' ?>>Diterima</option>
                    <option value="completed" <?= $order->status == 'completed' ? 'selected' : '' ?>>Selesai</option>
                    <option value="cancelled" <?= $order->status == 'cancelled' ? 'selected' : '' ?>>Dibatalkan</option>
                </select>
                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const updateStatusForm = document.getElementById('updateStatusForm');
    
    updateStatusForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch(this.getAttribute('action'), {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Tambahkan alert sukses
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show mt-3';
                alert.innerHTML = `
                    ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                updateStatusForm.after(alert);
                
                // Refresh halaman setelah 2 detik
                setTimeout(() => {
                    location.reload();
                }, 2000);
            } else {
                // Tambahkan alert error
                const alert = document.createElement('div');
                alert.className = 'alert alert-danger alert-dismissible fade show mt-3';
                alert.innerHTML = `
                    ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                updateStatusForm.after(alert);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
</script>

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