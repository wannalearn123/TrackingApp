<?php
// filepath: app/Views/user/history.php
$this->extend('layouts/user_layout');
$this->section('page_content');
?>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">
                    <i class="fas fa-history me-2"></i> Riwayat Training
                </h2>
                <p class="text-muted mb-0">Lihat semua aktivitas training kamu</p>
            </div>
            <a href="<?= base_url('user/training/start') ?>" class="btn btn-primary">
                <i class="fas fa-play-circle me-2"></i> Mulai Training Baru
            </a>
        </div>
    </div>
    
    <!-- Summary Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-running fa-2x text-primary mb-2"></i>
                    <h4 class="mb-0"><?= count($activities ?? []) ?></h4>
                    <small class="text-muted">Total Training</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-route fa-2x text-success mb-2"></i>
                    <h4 class="mb-0"><?= number_format($totalDistance ?? 0, 2) ?></h4>
                    <small class="text-muted">Total Jarak (km)</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x text-info mb-2"></i>
                    <h4 class="mb-0"><?= date('H:i:s', $totalDuration ?? 0) ?></h4>
                    <small class="text-muted">Total Durasi</small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?= base_url('user/history') ?>" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" class="form-control" name="date_from" 
                           value="<?= $filters['date_from'] ?? '' ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" class="form-control" name="date_to" 
                           value="<?= $filters['date_to'] ?? '' ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i> Filter
                        </button>
                        <a href="<?= base_url('user/history') ?>" class="btn btn-secondary">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Activities List -->
    <?php if (!empty($activities)): ?>
        <div class="row">
            <?php foreach ($activities as $activity): ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="card-title mb-1">
                                        <i class="fas fa-running me-2 text-primary"></i>
                                        Training Session
                                    </h5>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        <?= date('d M Y, H:i', strtotime($activity['activity_date'])) ?>
                                    </small>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url('user/training/summary/' . $activity['id']) ?>">
                                                <i class="fas fa-eye me-2"></i> Lihat Detail
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="<?= base_url('user/history/delete/' . $activity['id']) ?>" 
                                                  onsubmit="return confirm('Yakin hapus training ini?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-trash me-2"></i> Hapus
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded p-2 me-2">
                                            <i class="fas fa-route text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold"><?= number_format($activity['distance'], 2) ?> km</div>
                                            <small class="text-muted">Jarak</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info bg-opacity-10 rounded p-2 me-2">
                                            <i class="fas fa-clock text-info"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold"><?= gmdate('H:i:s', $activity['duration']) ?></div>
                                            <small class="text-muted">Durasi</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success bg-opacity-10 rounded p-2 me-2">
                                            <i class="fas fa-tachometer-alt text-success"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold"><?= number_format($activity['avg_pace'], 2) ?> km/h</div>
                                            <small class="text-muted">Kecepatan</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning bg-opacity-10 rounded p-2 me-2">
                                            <i class="fas fa-fire text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <a href="<?= base_url('user/training/summary/' . $activity['id']) ?>" 
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-eye me-2"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <?php if (!empty($pager)): ?>
            <div class="d-flex justify-content-center mt-4">
                <?= $pager->links() ?>
            </div>
        <?php endif; ?>
        
    <?php else: ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox fa-5x text-muted mb-4"></i>
                <h4 class="text-muted">Belum Ada Riwayat Training</h4>
                <p class="text-muted mb-4">Mulai training pertamamu dan catat progressnya!</p>
                <a href="<?= base_url('user/training/start') ?>" class="btn btn-primary btn-lg">
                    <i class="fas fa-play-circle me-2"></i> Mulai Training Sekarang
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php $this->endSection(); ?>