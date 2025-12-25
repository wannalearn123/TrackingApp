<?php
// filepath: app/Views/auth/login.php
$this->extend('layouts/main');
$this->section('content');
?>

<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
    <div class="login-container">
        <div class="card shadow-lg mb-4 p-5">
            <div class='login-header mb-4 text-center'>
                <h1><i class="fas fa-running"></i>Login</h1>
                <p>Masuk untuk melacak aktivitas training Anda</p>
            </div>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="<?= base_url('login/authenticate') ?>">
                <?= csrf_field() ?>
                
                <div class="form-group mb-3">
                    <label class='form-label' for="username">
                        Username / Email
                    </label>
                    <input type="text" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" 
                        id="username" name="username" value="<?= old('username') ?>" 
                        placeholder="Masukkan username atau email" required>
                </div>
                
                <div class="form-group mb-3">
                    <label class='form-label' for="password">
                        Password
                    </label>
                    <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                        id="password" name="password" value="<?= old('password') ?>" 
                        placeholder="Masukkan password" required>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 p-3 fw-bold">
                    Login
                </button>
            </form>

            <div class="register-link mt-3">
                Belum punya akun? <a href="<?= base_url('register') ?>">Daftar di sini</a>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>