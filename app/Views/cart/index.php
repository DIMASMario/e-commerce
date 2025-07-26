<?php
$this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <h1 class="mb-4">Keranjang Belanja</h1>
    
    <?php if (empty($cartItems)): ?>
        <div class="alert alert-info">
            <p class="mb-0">Keranjang belanja Anda masih kosong.</p>
            <a href="<?= base_url('products') ?>" class="btn btn-primary mt-3">Belanja Sekarang</a>
        </div>
    <?php else: ?>
        <form action="<?= base_url('cart/update') ?>" method="post" id="cartForm">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Item Keranjang (<?= count($cartItems) ?>)</h5>
                                <a href="<?= base_url('cart/clear') ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin mengosongkan keranjang?')">
                                    <i class="bi bi-trash"></i> Kosongkan Keranjang
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th style="width: 150px;">Jumlah</th>
                                            <th class="text-end">Harga</th>
                                            <th class="text-end">Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cartItems as $item): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="<?= base_url('uploads/products/' . $item['image']) ?>" alt="<?= esc($item['name']) ?>" class="img-thumbnail me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                        <div>
                                                            <h6 class="mb-0"><?= esc($item['name']) ?></h6>
                                                            <small class="text-muted"><?= esc($item['category_name']) ?></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="decrementQuantity('qty_<?= $item['id'] ?>')">
                                                            <i class="bi bi-dash"></i>
                                                        </button>
                                                        <input type="number" min="1" max="100" class="form-control text-center item-quantity" id="qty_<?= $item['id'] ?>" name="<?= $item['id'] ?>[qty]" value="<?= $item['quantity'] ?>" data-price="<?= $item['price'] ?>" onchange="updateSubtotal(this)">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="incrementQuantity('qty_<?= $item['id'] ?>')">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="text-end">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                                <td class="text-end fw-bold subtotal-cell" id="subtotal_<?= $item['id'] ?>">
                                                    Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>
                                                </td>
                                                <td class="text-end">
                                                    <a href="<?= base_url('cart/remove/' . $item['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                        <i class="bi bi-x"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('products') ?>" class="btn btn-outline-primary">
                                    <i class="bi bi-arrow-left"></i> Lanjut Belanja
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Update Keranjang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card shadow-sm mb-4 sticky-lg-top" style="top: 20px;">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Ringkasan Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal (<?= count($cartItems) ?> item)</span>
                                <span id="cart-subtotal">Rp <?= number_format($cartTotal, 0, ',', '.') ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Biaya Pengiriman</span>
                                <span class="text-success">Gratis</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">Total</h5>
                                <h5 class="text-danger mb-0" id="cart-total">Rp <?= number_format($cartTotal, 0, ',', '.') ?></h5>
                            </div>
                            <div class="d-grid">
                                <a href="<?= base_url('checkout') ?>" class="btn btn-success btn-lg">
                                    <i class="bi bi-cart-check"></i> Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function incrementQuantity(inputId) {
        const input = document.getElementById(inputId);
        if (!input) return;
        
        let value = parseInt(input.value);
        const max = parseInt(input.getAttribute('max')) || 100;
        
        if (value < max) {
            input.value = value + 1;
            updateSubtotal(input);
        }
    }

    function decrementQuantity(inputId) {
        const input = document.getElementById(inputId);
        if (!input) return;
        
        let value = parseInt(input.value);
        const min = parseInt(input.getAttribute('min')) || 1;
        
        if (value > min) {
            input.value = value - 1;
            updateSubtotal(input);
        }
    }

    function updateSubtotal(input) {
        // Mendapatkan harga dari data attribute
        const price = parseFloat(input.dataset.price);
        const quantity = parseInt(input.value);
        const itemId = input.id.replace('qty_', '');
        
        // Update subtotal untuk item ini
        const subtotalCell = document.getElementById('subtotal_' + itemId);
        const subtotal = price * quantity;
        subtotalCell.textContent = 'Rp ' + formatNumber(subtotal);
        
        // Update total keseluruhan
        updateCartTotal();
    }

    function updateCartTotal() {
        let total = 0;
        const quantityInputs = document.querySelectorAll('.item-quantity');
        
        quantityInputs.forEach(input => {
            const price = parseFloat(input.dataset.price);
            const quantity = parseInt(input.value);
            total += price * quantity;
        });
        
        document.getElementById('cart-subtotal').textContent = 'Rp ' + formatNumber(total);
        document.getElementById('cart-total').textContent = 'Rp ' + formatNumber(total);
    }

    function formatNumber(number) {
        return number.toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&.');
    }

    // Add event listeners untuk semua input quantity
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInputs = document.querySelectorAll('.item-quantity');
        quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                updateSubtotal(this);
            });
        });
    });
</script>
<?= $this->endSection() ?>