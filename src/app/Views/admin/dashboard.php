<?php
// filepath: app/Views/admin/dashboard.php
$this->extend('layouts/admin_layout');
$this->section('page_content');
?>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="fas fa-tachometer-alt me-2"></i> Dashboard Admin</h2>
            <p class="text-muted mb-0">Overview statistik dan aktivitas user</p>
        </div>
        <a href="<?= base_url('admin/export/dashboard') ?>" class="btn btn-primary">
            <i class="fas fa-file-pdf me-2"></i> Export PDF
        </a>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0"><?= $stats['total_users'] ?? 0 ?></h3>
                        <p class="mb-0">Total Users</p>
                    </div>
                    <i class="fas fa-users fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stat-card warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0"><?= $stats['pending_users'] ?? 0 ?></h3>
                        <p class="mb-0">Pending Approval</p>
                    </div>
                    <i class="fas fa-clock fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stat-card success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0"><?= $stats['active_users'] ?? 0 ?></h3>
                        <p class="mb-0">Active Today</p>
                    </div>
                    <i class="fas fa-running fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stat-card danger">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0"><?= $stats['completion_rate'] ?? 0 ?>%</h3>
                        <p class="mb-0">Completion Rate</p>
                    </div>
                    <i class="fas fa-chart-line fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- BMI Distribution & Alert Users -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i> Distribusi BMI Users</h5>
                </div>
                <div class="card-body">
                    <canvas id="bmiChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2 text-warning"></i> Alert Users</h5>
                </div>
                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                    <?php if (!empty($alert_users)): ?>
                        <?php foreach ($alert_users as $user): ?>
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <strong><?= esc($user['username']) ?></strong>
                                    <br>
                                    <small class="text-danger">
                                        BMI: <?= number_format($user['bmi'], 1) ?> 
                                        (<?= esc($user['bmi_category']) ?>)
                                    </small>
                                </div>
                                <a href="<?= base_url('admin/monitoring/user/' . $user['id']) ?>" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-muted">Tidak ada alert</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activities -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-history me-2"></i> Aktivitas Training Terbaru</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Tanggal</th>
                            <th>Jarak</th>
                            <th>Durasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recent_activities)): ?>
                            <?php foreach ($recent_activities as $activity): ?>
                                <tr>
                                    <td>
                                        <i class="fas fa-user-circle me-2"></i>
                                        <strong><?= esc($activity['username']) ?></strong>
                                    </td>
                                    <td><?= date('d M Y H:i', strtotime($activity['activity_date'])) ?></td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <?= number_format($activity['distance'], 2) ?> km
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?= format_duration($activity['duration']) ?>
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
                                <td colspan="5" class="text-center text-muted">Belum ada aktivitas</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
// BMI Distribution Chart
const bmiData = <?= json_encode($bmi_stats ?? ['underweight' => 0, 'normal' => 0, 'overweight' => 0, 'obese' => 0]) ?>;

const ctx = document.getElementById('bmiChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Underweight', 'Normal', 'Overweight', 'Obese'],
        datasets: [{
            data: [
                bmiData.underweight,
                bmiData.normal,
                bmiData.overweight,
                bmiData.obese
            ],
            backgroundColor: [
                '#3b82f6',
                '#10b981',
                '#f59e0b',
                '#ef4444'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
<?php $this->endSection(); ?>