<?php
// filepath: app/Views/user/dashboard.php
$this->extend('layouts/user_layout');
$this->section('page_content');
?>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="mb-1">
            <i class="fas fa-home me-2"></i> Dashboard
        </h2>
        <p class="text-muted mb-0">
            Selamat datang, <strong><?= session()->get('username') ?></strong>! 
            Mari mulai training hari ini 💪
        </p>
    </div>
    
    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0"><?= $stats['total_activities'] ?? 0 ?></h3>
                        <p class="mb-0">Total Training</p>
                    </div>
                    <i class="fas fa-running fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stat-card success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0"><?= number_format($stats['total_distance'] ?? 0, 2) ?></h3>
                        <p class="mb-0">Total Jarak (km)</p>
                    </div>
                    <i class="fas fa-route fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stat-card warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0"><?= gmdate('H:i', $stats['total_duration'] ?? 0) ?></h3>
                        <p class="mb-0">Total Durasi</p>
                    </div>
                    <i class="fas fa-clock fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stat-card danger">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0"><?= number_format($stats['total_calories'] ?? 0) ?></h3>
                        <p class="mb-0">Total Kalori</p>
                    </div>
                    <i class="fas fa-fire fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Physical Data & BMI -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-weight me-2"></i> Data Fisik Saya</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($physical_data)): ?>
                        <div class="text-center mb-3">
                            <h2 class="display-4 mb-0"><?= number_format($physical_data['bmi'], 1) ?></h2>
                            <p class="text-muted mb-2">BMI</p>
                            <span class="badge bg-<?= $bmi_color ?? 'secondary' ?> fs-6">
                                <?= $physical_data['bmi_category'] ?>
                            </span>
                        </div>
                        <hr>
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td><i class="fas fa-ruler-vertical me-2"></i> Tinggi:</td>
                                <td class="text-end"><strong><?= $physical_data['height'] ?> cm</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-weight me-2"></i> Berat:</td>
                                <td class="text-end"><strong><?= $physical_data['weight'] ?> kg</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-birthday-cake me-2"></i> Umur:</td>
                                <td class="text-end"><strong><?= $physical_data['age'] ?> tahun</strong></td>
                            </tr>
                        </table>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i>
                            <p class="text-muted">Data fisik belum diinput oleh admin</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i> Progress 7 Hari Terakhir</h5>
                </div>
                <div class="card-body">
                    <canvas id="progressChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card gradient-bg text-white">
                <div class="card-body">
                    <h4 class="mb-3"><i class="fas fa-rocket me-2"></i> Siap untuk training hari ini?</h4>
                    <div class="d-flex gap-3">
                        <a href="<?= base_url('user/training/start') ?>" class="btn btn-light btn-lg">
                            <i class="fas fa-play-circle me-2"></i> Mulai Training Sekarang
                        </a>
                        <a href="<?= base_url('user/history') ?>" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-history me-2"></i> Lihat Riwayat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activities -->
    <div class="card">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i> Aktivitas Terbaru</h5>
                <a href="<?= base_url('user/history') ?>" class="btn btn-sm btn-outline-primary">
                    Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if (!empty($recent_activities)): ?>
                <div class="list-group list-group-flush">
                    <?php foreach ($recent_activities as $activity): ?>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="fas fa-running me-2 text-primary"></i>
                                        Training - <?= date('d M Y', strtotime($activity['activity_date'])) ?>
                                    </h6>
                                    <div class="d-flex gap-3 small text-muted">
                                        <span>
                                            <i class="fas fa-route me-1"></i>
                                            <?= number_format($activity['distance'], 2) ?> km
                                        </span>
                                        <span>
                                            <i class="fas fa-clock me-1"></i>
                                            <?= gmdate('H:i:s', $activity['duration']) ?>
                                        </span>
                                        <span>
                                            <i class="fas fa-fire me-1"></i>
                                            <?= number_format($activity['calories_burned']) ?> kcal
                                        </span>
                                        <span>
                                            <i class="fas fa-tachometer-alt me-1"></i>
                                            <?= number_format($activity['avg_speed'], 2) ?> km/h
                                        </span>
                                    </div>
                                </div>
                                <a href="<?= base_url('user/training/summary/' . $activity['id']) ?>" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada aktivitas training</h5>
                    <p class="text-muted">Mulai training pertamamu sekarang!</p>
                    <a href="<?= base_url('user/training/start') ?>" class="btn btn-primary">
                        <i class="fas fa-play-circle me-2"></i> Mulai Training
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
// Progress Chart
const chartData = <?= json_encode($chart_data ?? ['labels' => [], 'distances' => [], 'calories' => []]) ?>;

const ctx = document.getElementById('progressChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: chartData.labels,
        datasets: [
            {
                label: 'Jarak (km)',
                data: chartData.distances,
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.2)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Kalori (kcal)',
                data: chartData.calories,
                borderColor: '#f59e0b',
                backgroundColor: 'rgba(245, 158, 11, 0.2)',
                tension: 0.4,
                fill: true,
                yAxisID: 'y1'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true,
                position: 'left',
                title: {
                    display: true,
                    text: 'Jarak (km)'
                }
            },
            y1: {
                beginAtZero: true,
                position: 'right',
                title: {
                    display: true,
                    text: 'Kalori (kcal)'
                },
                grid: {
                    drawOnChartArea: false
                }
            }
        }
    }
});
</script>
<?php $this->endSection(); ?>