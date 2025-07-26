<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Dashboard Saya</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="list-group">
                <a href="<?= base_url('user/dashboard') ?>" class="list-group-item list-group-item-action active">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="<?= base_url('user/profile') ?>" class="list-group-item list-group-item-action">
                    <i class="bi bi-person"></i> Profil Saya
                </a>
                <a href="<?= base_url('user/orders') ?>" class="list-group-item list-group-item-action">
                    <i class="bi bi-bag"></i> Pesanan Saya
                </a>
                <a href="<?= base_url('user/wishlist') ?>" class="list-group-item list-group-item-action">
                    <i class="bi bi-heart"></i> Wishlist
                </a>
                <a href="<?= base_url('auth/register-merchant') ?>" class="list-group-item list-group-item-action text-primary">
                    <i class="bi bi-shop"></i> Daftar sebagai Merchant
                </a>
                <a href="<?= base_url('auth/logout') ?>" class="list-group-item list-group-item-action text-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
        
        <div class="col-md-9">
            <!-- Recent Orders -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-bag"></i> Pesanan Terbaru
                </div>
                <div class="card-body">
                    <?php if (empty($recentOrders)): ?>
                        <p class="text-center">Anda belum memiliki pesanan</p>
                        <div class="text-center">
                            <a href="<?= base_url('products') ?>" class="btn btn-primary">Mulai Berbelanja</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentOrders as $order): ?>
                                        <tr>
                                            <td>#<?= $order->id ?></td>
                                            <td><?= date('d/m/Y', strtotime($order->created_at)) ?></td>
                                            <td>Rp <?= number_format($order->total_price, 0, ',', '.') ?></td>
                                            <td>
                                                <?php if ($order->status == 'pending'): ?>
                                                    <span class="badge bg-warning">Menunggu Pembayaran</span>
                                                <?php elseif ($order->status == 'paid'): ?>
                                                    <span class="badge bg-info">Dibayar</span>
                                                <?php elseif ($order->status == 'processing'): ?>
                                                    <span class="badge bg-primary">Diproses</span>
                                                <?php elseif ($order->status == 'shipped'): ?>
                                                    <span class="badge bg-info">Dikirim</span>
                                                <?php elseif ($order->status == 'delivered'): ?>
                                                    <span class="badge bg-success">Diterima</span>
                                                <?php elseif ($order->status == 'completed'): ?>
                                                    <span class="badge bg-success">Selesai</span>
                                                <?php elseif ($order->status == 'cancelled'): ?>
                                                    <span class="badge bg-danger">Dibatalkan</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary"><?= ucfirst($order->status) ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('user/orders/detail/' . $order->id) ?>" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-eye"></i> Detail
                                                </a>
                                                <?php if ($order->status == 'pending'): ?>
                                                    <a href="<?= base_url('user/payments/add/' . $order->id) ?>" class="btn btn-sm btn-success">
                                                        <i class="bi bi-credit-card"></i> Bayar
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end">
                            <a href="<?= base_url('user/orders') ?>" class="btn btn-outline-primary">Lihat Semua Pesanan</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Wishlist Preview -->
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <i class="bi bi-heart"></i> Wishlist Saya
                </div>
                <div class="card-body">
                    <?php if (empty($wishlistItems)): ?>
                        <p class="text-center">Wishlist Anda kosong</p>
                        <div class="text-center">
                            <a href="<?= base_url('products') ?>" class="btn btn-primary">Jelajahi Produk</a>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($wishlistItems as $item): ?>
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100">
                                        <img src="<?= base_url('uploads/products/' . $item['image']) ?>" class="card-img-top" alt="<?= $item['name'] ?>">
                                        <div class="card-body">
                                            <h6 class="card-title"><?= $item['name'] ?></h6>
                                            <p class="card-text">Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                                            <a href="<?= base_url('products/' . $item['product_id']) ?>" class="btn btn-sm btn-primary">Lihat</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="text-end mt-3">
                            <a href="<?= base_url('user/wishlist') ?>" class="btn btn-outline-danger">Lihat Semua Wishlist</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Recommended Products -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-stars"></i> Rekomendasi Untuk Anda
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($recommendedProducts as $product): ?>
                            <div class="col-md-3 mb-3">
                                <div class="card h-100">
                                    <img src="<?= base_url('uploads/products/' . $product['image']) ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                                    <div class="card-body">
                                        <h6 class="card-title"><?= $product['name'] ?></h6>
                                        <p class="card-text">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                                        <div class="d-flex justify-content-between">
                                            <a href="<?= base_url('products/' . $product['id']) ?>" class="btn btn-sm btn-primary">Detail</a>
                                            <form action="<?= base_url('cart/add') ?>" method="post" class="d-inline">
                                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="bi bi-cart-plus"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="text-center mt-3">
                        <a href="<?= base_url('products') ?>" class="btn btn-outline-success">Jelajahi Produk Lainnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
