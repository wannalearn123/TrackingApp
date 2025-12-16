<?php
// filepath: app/Views/layouts/admin_layout.php
$this->extend('layouts/main');
$this->section('content');
?>

<!-- Sidebar -->
<div class="sidebar">
    <div class="p-3 gradient-bg text-white text-center">
        <h4><i class="fas fa-running"></i> Tracking App</h4>
        <small>Admin Panel</small>
    </div>
    
    <nav class="nav flex-column mt-3">
        <a class="nav-link <?= url_is('admin/dashboard') ? 'active' : '' ?>" href="<?= base_url('admin/dashboard') ?>">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>
        <a class="nav-link <?= url_is('admin/users*') ? 'active' : '' ?>" href="<?= base_url('admin/users') ?>">
            <i class="fas fa-users me-2"></i> Manajemen User
        </a>
        <a class="nav-link <?= url_is('admin/monitoring*') ? 'active' : '' ?>" href="<?= base_url('admin/monitoring') ?>">
            <i class="fas fa-chart-line me-2"></i> Monitoring
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
                    <i class="fas fa-user-shield"></i>
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