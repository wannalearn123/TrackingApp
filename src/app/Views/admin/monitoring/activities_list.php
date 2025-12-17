<?php
// filepath: app/Views/admin/monitoring/activities_list.php
$this->extend('layouts/admin_layout');
$this->section('page_content');
?>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="mb-1"><i class="fas fa-chart-line me-2"></i> Monitoring Aktivitas</h2>
        <p class="text-muted mb-0">Monitor semua aktivitas training user</p>
    </div>
    
    <!-- Filter & Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?= base_url('admin/monitoring') ?>" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Cari User</label>
                    <input type="text" class="form-control" name="search" 
                           value="<?= $filters['search'] ?? '' ?>" 
                           placeholder="Username atau email">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" name="date_from" 
                           value="<?= $filters['date_from'] ?? '' ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" name="date_to" 
                           value="<?= $filters['date_to'] ?? '' ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="<?= base_url('admin/monitoring') ?>" class="btn btn-secondary">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Activities Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Tanggal & Waktu</th>
                            <th>Jarak</th>
                            <th>Durasi</th>
                            <th>Kecepatan</th>
                            <th>Kalori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($activities)): ?>
                            <?php foreach ($activities as $activity): ?>
                                <tr>
                                    <td>
                                        <a href="<?= base_url('admin/monitoring/user/' . $activity['user_id']) ?>" 
                                           class="text-decoration-none">
                                            <i class="fas fa-user-circle me-2"></i>
                                            <strong><?= esc($activity['username']) ?></strong>
                                        </a>
                                        <br>
                                        <small class="text-muted">
                                            BMI: <?= number_format($activity['bmi'] ?? 0, 1) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <?= date('d M Y', strtotime($activity['activity_date'])) ?>
                                        <br>
                                        <small class="text-muted">
                                            <?= date('H:i', strtotime($activity['activity_date'])) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <i class="fas fa-route me-1"></i>
                                            <?= number_format($activity['distance'], 2) ?> km
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            <i class="fas fa-clock me-1"></i>
                                            <?= gmdate('H:i:s', $activity['duration']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            <?= number_format($activity['avg_pace'], 2) ?> km/h
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/monitoring/user/' . $activity['user_id']) ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    Belum ada aktivitas training
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if (!empty($pager)): ?>
                <div class="mt-3">
                    <?= $pager->links() ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>