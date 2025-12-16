<?php
// filepath: app/Views/layouts/user_layout.php
$this->extend('layouts/main');
$this->section('content');
?>

<!-- Sidebar -->
<div class="sidebar">
    <div class="p-3 gradient-bg text-white text-center">
        <h4><i class="fas fa-running"></i> Tracking App</h4>
        <small>User Panel</small>
    </div>
    
    <nav class="nav flex-column mt-3">
        <a class="nav-link <?= url_is('user/dashboard') ? 'active' : '' ?>" href="<?= base_url('user/dashboard') ?>">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>
        <a class="nav-link <?= url_is('user/training*') ? 'active' : '' ?>" href="<?= base_url('user/training/start') ?>">
            <i class="fas fa-play-circle me-2"></i> Mulai Training
        </a>
        <a class="nav-link <?= url_is('user/history*') ? 'active' : '' ?>" href="<?= base_url('user/history') ?>">
            <i class="fas fa-history me-2"></i> Riwayat Training
        </a>
        <a class="nav-link <?= url_is('user/notifications*') ? 'active' : '' ?>" href="<?= base_url('user/notifications') ?>">
            <i class="fas fa-bell me-2"></i> Notifikasi
            <?php if (isset($unreadNotifications) && $unreadNotifications > 0): ?>
                <span class="badge bg-danger"><?= $unreadNotifications ?></span>
            <?php endif; ?>
        </a>
        <hr>
        <a class="nav-link text-danger" href="<?= base_url('logout') ?>">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Topbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 rounded shadow-sm">
        <div class="container-fluid">
            <button class="btn btn-light d-lg-none" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="ms-auto d-flex align-items-center">
                <span class="me-3">
                    <i class="fas fa-user"></i>
                    <?= session()->get('username') ?>
                </span>
            </div>
        </div>
    </nav>
    
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <!-- Page Content -->
    <?= $this->renderSection('page_content') ?>
</div>

<script>
    // Sidebar toggle for mobile
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('show');
    });
</script>

<?php $this->endSection(); ?>