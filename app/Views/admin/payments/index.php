<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1 class="mb-4">Kelola Pembayaran</h1>

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

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <ul class="nav nav-tabs card-header-tabs" id="paymentTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="waiting-tab" data-bs-toggle="tab" data-bs-target="#waiting" type="button" role="tab" aria-controls="waiting" aria-selected="true">
                        Menunggu Verifikasi
                        <span class="badge bg-warning"><?= count($waitingPayments) ?></span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="verified-tab" data-bs-toggle="tab" data-bs-target="#verified" type="button" role="tab" aria-controls="verified" aria-selected="false">
                        Terverifikasi
                        <span class="badge bg-success"><?= count($verifiedPayments) ?></span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button" role="tab" aria-controls="rejected" aria-selected="false">
                        Ditolak
                        <span class="badge bg-danger"><?= count($rejectedPayments) ?></span>
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body tab-content" id="paymentTabsContent">
            <!-- Tab Menunggu Verifikasi -->
            <div class="tab-pane fade show active" id="waiting" role="tabpanel" aria-labelledby="waiting-tab">
                <?php if (!empty($waitingPayments)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle" id="tableWaiting">
                            <thead class="table-primary">
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Total Harga</th>
                                    <th>Bukti Bayar</th>
                                    <th>Tanggal Upload</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($waitingPayments as $payment): ?>
                                    <tr>
                                        <td><?= $payment['id'] ?></td>
                                        <td><?= $payment['invoice_number'] ?: 'INV-' . str_pad($payment['order_id'], 4, '0', STR_PAD_LEFT) ?></td>
                                        <td><?= esc($payment['user_name']) ?></td>
                                        <td>Rp <?= number_format($payment['total_price'] ?? 0, 0, ',', '.') ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#proofModal<?= $payment['id'] ?>">
                                                <i class="bi bi-image"></i> Lihat
                                            </button>
                                            
                                            <!-- Modal Bukti Pembayaran -->
                                            <div class="modal fade" id="proofModal<?= $payment['id'] ?>" tabindex="-1" aria-labelledby="proofModalLabel<?= $payment['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="proofModalLabel<?= $payment['id'] ?>">Bukti Pembayaran #<?= $payment['id'] ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="<?= base_url('uploads/payment/' . $payment['payment_proof']) ?>" class="img-fluid" alt="Bukti Pembayaran">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            <a href="<?= base_url('uploads/payment/' . $payment['payment_proof']) ?>" class="btn btn-primary" target="_blank">Lihat Ukuran Penuh</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= date('d M Y H:i', strtotime($payment['created_at'])) ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('admin/payments/detail/' . $payment['id']) ?>" class="btn btn-sm btn-info text-white">
                                                    <i class="bi bi-info-circle"></i> Detail
                                                </a>
                                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#verifyModal<?= $payment['id'] ?>">
                                                    <i class="bi bi-check-circle"></i> Terima
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal<?= $payment['id'] ?>">
                                                    <i class="bi bi-x-circle"></i> Tolak
                                                </button>
                                            </div>
                                            
                                            <!-- Modal Verifikasi -->
                                            <div class="modal fade" id="verifyModal<?= $payment['id'] ?>" tabindex="-1" aria-labelledby="verifyModalLabel<?= $payment['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="verifyModalLabel<?= $payment['id'] ?>">Verifikasi Pembayaran</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="<?= base_url('admin/payments/verify/' . $payment['id']) ?>" method="post">
                                                            <div class="modal-body">
                                                                <p>Apakah Anda yakin ingin memverifikasi pembayaran ini?</p>
                                                                <div class="mb-3">
                                                                    <label for="verification_note" class="form-label">Catatan (opsional)</label>
                                                                    <textarea class="form-control" id="verification_note" name="verification_note" rows="2"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-success">Verifikasi</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Modal Tolak -->
                                            <div class="modal fade" id="rejectModal<?= $payment['id'] ?>" tabindex="-1" aria-labelledby="rejectModalLabel<?= $payment['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="rejectModalLabel<?= $payment['id'] ?>">Tolak Pembayaran</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="<?= base_url('admin/payments/reject/' . $payment['id']) ?>" method="post">
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="reason" class="form-label">Alasan Penolakan</label>
                                                                    <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
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
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Tidak ada pembayaran yang menunggu verifikasi.
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Tab Terverifikasi -->
            <div class="tab-pane fade" id="verified" role="tabpanel" aria-labelledby="verified-tab">
                <?php if (!empty($verifiedPayments)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle" id="tableVerified">
                            <thead class="table-success">
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Total Harga</th>
                                    <th>Bukti Bayar</th>
                                    <th>Tanggal Verifikasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($verifiedPayments as $payment): ?>
                                    <tr>
                                        <td><?= $payment['id'] ?></td>
                                        <td><?= $payment['invoice_number'] ?: 'INV-' . str_pad($payment['order_id'], 4, '0', STR_PAD_LEFT) ?></td>
                                        <td><?= esc($payment['user_name']) ?></td>
                                        <td>Rp <?= number_format($payment['total_price'] ?? 0, 0, ',', '.') ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#proofModalV<?= $payment['id'] ?>">
                                                <i class="bi bi-image"></i> Lihat
                                            </button>
                                            
                                            <!-- Modal Bukti Pembayaran -->
                                            <div class="modal fade" id="proofModalV<?= $payment['id'] ?>" tabindex="-1" aria-labelledby="proofModalVLabel<?= $payment['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="proofModalVLabel<?= $payment['id'] ?>">Bukti Pembayaran #<?= $payment['id'] ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="<?= base_url('uploads/payment/' . $payment['payment_proof']) ?>" class="img-fluid" alt="Bukti Pembayaran">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            <a href="<?= base_url('uploads/payment/' . $payment['payment_proof']) ?>" class="btn btn-primary" target="_blank">Lihat Ukuran Penuh</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= date('d M Y H:i', strtotime($payment['updated_at'] ?? $payment['created_at'])) ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/payments/detail/' . $payment['id']) ?>" class="btn btn-sm btn-info text-white">
                                                <i class="bi bi-info-circle"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Tidak ada pembayaran yang terverifikasi.
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Tab Ditolak -->
            <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                <?php if (!empty($rejectedPayments)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle" id="tableRejected">
                            <thead class="table-danger">
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Total Harga</th>
                                    <th>Bukti Bayar</th>
                                    <th>Alasan Penolakan</th>
                                    <th>Tanggal Ditolak</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rejectedPayments as $payment): ?>
                                    <tr>
                                        <td><?= $payment['id'] ?></td>
                                        <td><?= $payment['invoice_number'] ?: 'INV-' . str_pad($payment['order_id'], 4, '0', STR_PAD_LEFT) ?></td>
                                        <td><?= esc($payment['user_name']) ?></td>
                                        <td>Rp <?= number_format($payment['total_price'] ?? 0, 0, ',', '.') ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#proofModalR<?= $payment['id'] ?>">
                                                <i class="bi bi-image"></i> Lihat
                                            </button>
                                            
                                            <!-- Modal Bukti Pembayaran -->
                                            <div class="modal fade" id="proofModalR<?= $payment['id'] ?>" tabindex="-1" aria-labelledby="proofModalRLabel<?= $payment['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="proofModalRLabel<?= $payment['id'] ?>">Bukti Pembayaran #<?= $payment['id'] ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="<?= base_url('uploads/payment/' . $payment['payment_proof']) ?>" class="img-fluid" alt="Bukti Pembayaran">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            <a href="<?= base_url('uploads/payment/' . $payment['payment_proof']) ?>" class="btn btn-primary" target="_blank">Lihat Ukuran Penuh</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= $payment['verification_note'] ?? '-' ?></td>
                                        <td><?= date('d M Y H:i', strtotime($payment['updated_at'] ?? $payment['created_at'])) ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/payments/detail/' . $payment['id']) ?>" class="btn btn-sm btn-info text-white">
                                                <i class="bi bi-info-circle"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Tidak ada pembayaran yang ditolak.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('#tableWaiting').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
            }
        });
        
        $('#tableVerified').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
            }
        });
        
        $('#tableRejected').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
            }
        });
    });
</script>
<?= $this->endSection() ?>
