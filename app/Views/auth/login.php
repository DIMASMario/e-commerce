<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="auth-page d-flex align-items-center justify-content-center min-vh-100">
    <div class="auth-card card shadow-sm p-4" style="width: 100%; max-width: 420px;">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">Login</h4>
        </div>
        <div class="card-body">
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <form action="<?= base_url('auth/login') ?>" method="post" novalidate>
                <div class="mb-3">
                    <label class="form-label">Login Sebagai</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role" id="roleUser" value="user" checked>
                        <label class="form-check-label" for="roleUser">User</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role" id="roleMerchant" value="merchant">
                        <label class="form-check-label" for="roleMerchant">Merchant</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role" id="roleAdmin" value="admin">
                        <label class="form-check-label" for="roleAdmin">Admin</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" placeholder="Masukkan email anda" required>
                    </div>
                    <?php if(isset($errors['email'])): ?>
                        <div class="text-danger"><?= $errors['email'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password anda" required>
                        <button class="btn btn-outline-secondary toggle-password" type="button" tabindex="-1">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <?php if(isset($errors['password'])): ?>
                        <div class="text-danger"><?= $errors['password'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                    </button>
                </div>
            </form>
            <div class="text-center mt-4">
                <p class="mb-0">Belum punya akun? <a href="<?= base_url('auth/register') ?>" class="text-primary fw-bold">Daftar Sekarang</a></p>
            </div>
            <div class="text-center mt-3">
                <a href="<?= base_url('/') ?>" class="text-decoration-none text-primary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle password visibility
    document.querySelector('.toggle-password').addEventListener('click', function() {
        const passwordInput = document.querySelector('#password');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
</script>
<?= $this->endSection() ?>
