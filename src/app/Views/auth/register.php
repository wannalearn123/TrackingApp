<?php
// filepath: app/Views/auth/register.php
$this->extend('layouts/main');
$this->section('content');
?>

<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
    <div class="register-container ">
        <div class="card shadow-lg mb-4 p-5">
            <div class="register-header mb-4 text-center">
                <h1><i class="fas fa-running"></i> Register</h1>
                <p>Daftar untuk mulai tracking aktivitas training Anda</p>
            </div>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="<?= base_url('register/store') ?>">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label for="username" class="form-label">
                        <i class="fas fa-user me-1"></i> Username
                    </label>
                    <input type="text" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" 
                        id="username" name="username" value="<?= old('username') ?>" 
                        placeholder="Pilih username unik" required>
                    <?php if (isset($errors['username'])): ?>
                        <div class="invalid-feedback"><?= $errors['username'] ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-1"></i> Email
                    </label>
                    <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                        id="email" name="email" value="<?= old('email') ?>" 
                        placeholder="email@example.com" required>
                    <?php if (isset($errors['email'])): ?>
                        <div class="invalid-feedback"><?= $errors['email'] ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-1"></i> Password
                    </label>
                    <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                        id="password" name="password" 
                        placeholder="Minimal 6 karakter" required>
                    <?php if (isset($errors['password'])): ?>
                        <div class="invalid-feedback"><?= $errors['password'] ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="mb-4">
                    <label for="password_confirm" class="form-label">
                        <i class="fas fa-lock me-1"></i> Konfirmasi Password
                    </label>
                    <input type="password" class="form-control <?= isset($errors['password_confirm']) ? 'is-invalid' : '' ?>" 
                        id="password_confirm" name="password_confirm" 
                        placeholder="Ketik ulang password" required>
                    <?php if (isset($errors['password_confirm'])): ?>
                        <div class="invalid-feedback"><?= $errors['password_confirm'] ?></div>
                    <?php endif; ?>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 p-3 fw-bold">
                    <i class="fas fa-user-plus me-2"></i> Daftar Sekarang
                </button>
            </form>
            
                            <div class="text-center mt-3">
                Sudah punya akun? <a href="<?= base_url('login') ?>">Login di sini</a>
            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>