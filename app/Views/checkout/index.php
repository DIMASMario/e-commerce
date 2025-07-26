<?php $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col">
            <h1>Checkout</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('cart') ?>">Keranjang</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- SATU FORM UNTUK SEMUA INPUT -->
    <form id="checkout-form" action="<?= base_url('checkout/process') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="total_amount" id="total_amount" value="<?= $cartTotal ?>">

        <div class="row">
            <div class="col-md-8">
                <!-- Daftar Belanja -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-basket"></i> Daftar Belanja</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $totalCheckout = 0; ?>
                                    <?php foreach ($cartItems as $item): ?>
                                    <?php $subtotal = $item['price'] * $item['quantity']; ?>
                                    <?php $totalCheckout += $subtotal; ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?= base_url('uploads/products/' . $item['image']) ?>" alt="<?= $item['name'] ?>" class="me-3 checkout-product-img" style="width: 60px; height: 60px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-0"><?= $item['name'] ?></h6>
                                                    <small class="text-muted"><?= $item['category_name'] ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <?= $item['quantity'] ?>
                                            <!-- Hidden input untuk menyimpan data produk -->
                                            <input type="hidden" name="products[<?= $item['id'] ?>][id]" value="<?= $item['product_id'] ?>">
                                            <input type="hidden" name="products[<?= $item['id'] ?>][quantity]" value="<?= $item['quantity'] ?>">
                                            <input type="hidden" name="products[<?= $item['id'] ?>][price]" value="<?= $item['price'] ?>">
                                        </td>
                                        <td class="text-end align-middle">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                        <td class="text-end align-middle fw-bold">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pembeli -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-person"></i> Informasi Pengiriman</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= session()->get('name') ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= session()->get('email') ?>" readonly>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required><?= old('address') ?></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">No. Handphone</label>
                                <div class="input-group">
                                    <span class="input-group-text">+62</span>
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?= old('phone') ?>" placeholder="8xxxxxxxxxx" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">Kota</label>
                                <input type="text" class="form-control" id="city" name="city" value="<?= old('city') ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="postal_code" class="form-label">Kode Pos</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code" value="<?= old('postal_code') ?>" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pembayaran -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-credit-card"></i> Metode Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <p>Silakan pilih metode pembayaran dan transfer ke rekening yang dituju.</p>
                        </div>
                        <div class="form-check border rounded p-3 mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="payment_bca" value="BCA" required>
                            <label class="form-check-label w-100" for="payment_bca">
                                <h6 class="mb-1">Bank BCA</h6>
                                <small class="d-block">No. Rekening: <strong>123456789</strong></small>
                                <small class="d-block">Atas Nama: <strong>PT Socksin Indonesia</strong></small>
                            </label>
                        </div>
                        <div class="form-check border rounded p-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="payment_mandiri" value="Mandiri" required>
                            <label class="form-check-label w-100" for="payment_mandiri">
                                <h6 class="mb-1">Bank Mandiri</h6>
                                <small class="d-block">No. Rekening: <strong>987654321</strong></small>
                                <small class="d-block">Atas Nama: <strong>PT Socksin Indonesia</strong></small>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Bukti Pembayaran -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-receipt-cutoff"></i> Bukti Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <p><i class="bi bi-info-circle"></i> Unggah bukti transfer pembayaran Anda di sini. Format yang diizinkan: JPG, JPEG, PNG (Max. 2MB)</p>
                        </div>
                        <div class="mb-3">
                            <label for="payment_proof" class="form-label">Bukti Pembayaran</label>
                            <input class="form-control" type="file" id="payment_proof" name="payment_proof" required data-preview="preview-image">
                            <div id="preview-container" class="mt-2 d-none">
                                <img id="preview-image" src="#" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Pesanan (Sidebar Kanan) -->
            <div class="col-md-4">
                <div class="card shadow-sm sticky-top checkout-summary" style="top: 20px;">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-receipt"></i> Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal (<?= count($cartItems) ?> produk)</span>
                            <span id="checkout-subtotal">Rp <?= number_format($totalCheckout, 0, ',', '.') ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Biaya Pengiriman</span>
                            <span class="text-success">Gratis</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold text-danger fs-5" id="checkout-total">Rp <?= number_format($totalCheckout, 0, ',', '.') ?></span>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="terms_agree" required>
                            <label class="form-check-label" for="terms_agree">
                                Saya setuju dengan <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">syarat dan ketentuan</a>.
                            </label>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg w-100" id="checkout-btn">
                            <i class="bi bi-check-circle me-2"></i>Proses Pesanan
                        </button>
                        <div class="text-center mt-3">
                            <a href="<?= base_url('cart') ?>" class="text-decoration-none">
                                <i class="bi bi-arrow-left me-1"></i> Kembali ke Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal Syarat & Ketentuan -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Syarat dan Ketentuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>1. Umum</h6>
                <p>Syarat dan ketentuan ini mengatur penggunaan layanan Socksin. Dengan menggunakan layanan kami, Anda menyetujui syarat dan ketentuan ini.</p>
                <h6>2. Pesanan dan Pembayaran</h6>
                <p>Pembayaran harus dilakukan dalam waktu 24 jam setelah pesanan dibuat. Jika tidak, pesanan akan otomatis dibatalkan.</p>
                <h6>3. Pengiriman</h6>
                <p>Pengiriman akan dilakukan 1-3 hari kerja setelah pembayaran dikonfirmasi oleh admin.</p>
                <h6>4. Pengembalian</h6>
                <p>Pengembalian hanya dapat dilakukan jika produk cacat atau tidak sesuai dengan deskripsi.</p>
                <h6>5. Privasi</h6>
                <p>Kami menghargai privasi Anda. Data pribadi Anda hanya digunakan untuk keperluan transaksi dan tidak akan dibagikan kepada pihak ketiga tanpa izin.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Saya Mengerti</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkout-form');
    const submitButton = document.getElementById('checkout-btn');
    const paymentProofInput = document.getElementById('payment_proof');
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');
    const totalAmountInput = document.getElementById('total_amount');
    const checkoutTotal = document.getElementById('checkout-total');
    const termsCheckbox = document.getElementById('terms_agree');
    
    // Preview gambar saat dipilih
    paymentProofInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('d-none');
        }
    });

    // Fungsi untuk validasi form secara real-time
    function validateForm() {
        // Cek validitas semua field required
        let valid = true;
        const requiredFields = form.querySelectorAll('[required]');
        
        requiredFields.forEach(field => {
            if (!field.value) {
                valid = false;
            }
            
            // Khusus untuk radio buttons
            if (field.type === 'radio' && field.name === 'payment_method') {
                const radioGroup = document.getElementsByName('payment_method');
                let radioValid = false;
                radioGroup.forEach(radio => {
                    if (radio.checked) radioValid = true;
                });
                if (!radioValid) valid = false;
            }
            
            // Khusus untuk file input
            if (field.type === 'file' && !field.files.length) {
                valid = false;
            }
        });
        
        // Cek apakah checkbox syarat dan ketentuan dicentang
        if (!termsCheckbox.checked) {
            valid = false;
        }
        
        // Aktifkan atau nonaktifkan tombol berdasarkan validasi
        submitButton.disabled = !valid;
    }
    
    // Validasi saat inputan form berubah
    form.addEventListener('change', validateForm);
    form.addEventListener('input', validateForm);
    
    // Validasi khusus saat checkbox syarat dan ketentuan diubah
    termsCheckbox.addEventListener('change', validateForm);
    
    // Tambahkan event listener untuk radio button
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', validateForm);
    });
    
    // Memastikan nilai total tersimpan dengan benar
    totalAmountInput.value = <?= $totalCheckout ?>;
    
    // Validasi awal saat halaman dimuat
    setTimeout(validateForm, 500); // Tambahkan delay untuk memastikan semua elemen sudah di-render
});
</script>
<?= $this->endSection() ?>