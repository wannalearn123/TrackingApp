<?php
// filepath: app/Views/auth/waiting_approval.php
$this->extend('layouts/main');
$this->section('content');
?>

<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-info) 100%);">
    <div class="waiting-container">
        <div class="card shadow-lg mb-4 p-5">
            <div class="icon-container mb-4 text-center">
                <i class="fas fa-clock"></i>
            </div>
            
            <h1>Pendaftaran Berhasil!</h1>
            <p>Akun Anda sedang menunggu approval dari admin. Anda akan menerima notifikasi via email setelah akun disetujui.</p>
            
            <div class="info-box">
                <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i> Langkah Selanjutnya:</h5>
                <ul>
                    <li>Admin akan review pendaftaran Anda</li>
                    <li>Proses approval biasanya 1-2 hari kerja</li>
                    <li>Cek email untuk notifikasi approval</li>
                    <li>Setelah approved, Anda bisa login</li>
                </ul>
            </div>

            <a href="<?= base_url('login') ?>" class="btn btn-primary p-2">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Login
            </a>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>