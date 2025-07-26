<?php
$this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detail Pembayaran #<?= $payment['id'] ?></h1>
        <a href="<?= base_url('admin/payments') ?>" class="btn btn-secondary">
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
        <!-- Payment Information -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">ID Pembayaran</th>
                            <td>#<?= $payment['id'] ?></td>
                        </tr>
                        <tr>
                            <th>ID Pesanan</th>
                            <td><a href="<?= base_url('admin/orders/detail/' . $payment['order_id']) ?>">#<?= $payment['order_id'] ?></a></td>
                        </tr>
                        <tr>
                            <th>Invoice</th>
                            <td><?= $order['invoice_number'] ?: 'INV-' . str_pad($order['id'], 4, '0', STR_PAD_LEFT) ?></td>
                        </tr>
                        <tr>
                            <th>Nama Pelanggan</th>
                            <td><?= $user['name'] ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= $user['email'] ?></td>
                        </tr>
                        <tr>
                            <th>Total Pembayaran</th>
                            <td class="fw-bold text-primary">Rp <?= number_format($order['total_amount'] ?? $order['total_price'] ?? 0, 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Upload</th>
                            <td><?= date('d/m/Y H:i', strtotime($payment['created_at'])) ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <?php if ($payment['status'] == 'waiting' || $payment['status'] == 'pending_verification'): ?>
                                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                                <?php elseif ($payment['status'] == 'verified'): ?>
                                    <span class="badge bg-success">Terverifikasi</span>
                                <?php elseif ($payment['status'] == 'rejected'): ?>
                                    <span class="badge bg-danger">Ditolak</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php if ($payment['status'] != 'waiting' && $payment['status'] != 'pending_verification'): ?>
                        <tr>
                            <th>Tanggal Verifikasi</th>
                            <td><?= date('d/m/Y H:i', strtotime($payment['updated_at'])) ?></td>
                        </tr>
                        <?php if (!empty($payment['verification_note'])): ?>
                        <tr>
                            <th>Catatan Verifikasi</th>
                            <td><?= $payment['verification_note'] ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Payment Proof -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Bukti Pembayaran</h5>
                </div>
                <div class="card-body text-center">
                    <img src="<?= base_url('uploads/payment/' . $payment['payment_proof']) ?>" alt="Bukti Pembayaran" class="img-fluid img-thumbnail" style="max-height: 400px;">
                    <div class="mt-3">
                        <a href="<?= base_url('uploads/payment/' . $payment['payment_proof']) ?>" class="btn btn-sm btn-primary" target="_blank">
                            <i class="bi bi-eye"></i> Lihat Gambar Penuh
                        </a>
                        <a href="<?= base_url('uploads/payment/' . $payment['payment_proof']) ?>" class="btn btn-sm btn-success" download>
                            <i class="bi bi-download"></i> Download Gambar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Items -->
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Detail Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $calculatedTotal = 0;
                                foreach ($orderDetails as $item): 
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $calculatedTotal += $subtotal;
                                ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if (!empty($item['image'])): ?>
                                                <img src="<?= base_url('uploads/products/' . $item['image']) ?>" alt="<?= $item['name'] ?>" class="me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                <?php endif; ?>
                                                <?= $item['name'] ?>
                                            </div>
                                        </td>
                                        <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total</td>
                                    <td class="fw-bold text-primary">Rp <?= number_format($calculatedTotal, 0, ',', '.') ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Tindakan</h5>
                </div>
                <div class="card-body">
                    <?php if ($payment['status'] == 'waiting' || $payment['status'] == 'pending_verification'): ?>
                        <div class="d-grid gap-3">
                            <form action="<?= base_url('admin/payments/verify/' . $payment['id']) ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin memverifikasi pembayaran ini?');">
                                <div class="mb-3">
                                    <label for="verification_note" class="form-label">Catatan Verifikasi (opsional)</label>
                                    <textarea class="form-control" id="verification_note" name="verification_note" rows="2"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-check-circle"></i> Verifikasi Pembayaran
                                </button>
                            </form>
                            
                            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="bi bi-x-circle"></i> Tolak Pembayaran
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="alert <?= $payment['status'] == 'verified' ? 'alert-success' : 'alert-danger' ?>">
                            <?php if ($payment['status'] == 'verified'): ?>
                                <i class="bi bi-check-circle"></i> Pembayaran telah diverifikasi
                            <?php else: ?>
                                <i class="bi bi-x-circle"></i> Pembayaran ditolak
                            <?php endif; ?>
                        </div>
                        
                        <?php if ($payment['status'] == 'rejected'): ?>
                            <div class="alert alert-light border mt-3">
                                <h6>Alasan Penolakan:</h6>
                                <p class="mb-0"><?= $payment['verification_note'] ?? 'Tidak ada alasan yang diberikan.' ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Payment Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Tolak Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/payments/reject/' . $payment['id']) ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reason" class="form-label">Alasan Penolakan</label>
                        <textarea class="form-control" id="reason" name="reason" rows="4" required></textarea>
                        <div class="form-text">Alasan ini akan dikirimkan ke pelanggan</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>