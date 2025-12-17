<?php
// filepath: app/Views/admin/monitoring/user_detail.php
$this->extend('layouts/admin_layout');
$this->section('page_content');
?>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/monitoring') ?>">Monitoring</a></li>
                <li class="breadcrumb-item active"><?= esc($user['username']) ?></li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">
                    <i class="fas fa-user-circle me-2"></i> <?= esc($user['username']) ?>
                </h2>
                <p class="text-muted mb-0"><?= esc($user['email']) ?></p>
            </div>
            <a href="<?= base_url('admin/physical-data/create/' . $user['id']) ?>" 
               class="btn btn-primary">
                <i class="fas fa-edit me-2"></i> Update Data Fisik
            </a>
        </div>
    </div>
    
    <!-- User Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="mb-0"><?= number_format($physical_data['bmi'] ?? 0, 1) ?></h3>
                    <p class="text-muted mb-2">BMI</p>
                    <span class="badge bg-<?= $bmi_color ?? 'secondary' ?>">
                        <?= $physical_data['bmi_category'] ?? 'N/A' ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="mb-0"><?= count($activities ?? []) ?></h3>
                    <p class="text-muted mb-0">Total Aktivitas</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="mb-0"><?= number_format($stats['total_distance'] ?? 0, 2) ?></h3>
                    <p class="text-muted mb-0">Total Jarak (km)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="mb-0"><?= number_format($stats['total_calories'] ?? 0) ?></h3>
                    <p class="text-muted mb-0">Total Kalori</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Physical Data -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-weight me-2"></i> Data Fisik</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($physical_data)): ?>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Tinggi Badan:</strong></td>
                                <td><?= $physical_data['height'] ?> cm</td>
                            </tr>
                            <tr>
                                <td><strong>Berat Badan:</strong></td>
                                <td><?= $physical_data['weight'] ?> kg</td>
                            </tr>
                            <tr>
                                <td><strong>Umur:</strong></td>
                                <td><?= $physical_data['age'] ?> tahun</td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Kelamin:</strong></td>
                                <td><?= $physical_data['gender'] == 'male' ? 'Laki-laki' : 'Perempuan' ?></td>
                            </tr>
                            <?php if (!empty($physical_data['medical_conditions'])): ?>
                                <tr>
                                    <td><strong>Kondisi Medis:</strong></td>
                                    <td><?= esc($physical_data['medical_conditions']) ?></td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    <?php else: ?>
                        <p class="text-center text-muted">Data fisik belum diinput</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i> Progress Chart</h5>
                </div>
                <div class="card-body">
                    <canvas id="progressChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Activities History -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-history me-2"></i> Riwayat Aktivitas</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jarak</th>
                            <th>Durasi</th>
                            <th>Kecepatan</th>
                            <th>Kalori</th>
                            <th>Map</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($activities)): ?>
                            <?php foreach ($activities as $activity): ?>
                                <tr>
                                    <td><?= date('d M Y H:i', strtotime($activity['activity_date'])) ?></td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <?= number_format($activity['distance'], 2) ?> km
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?= gmdate('H:i:s', $activity['duration']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            <?= number_format($activity['avg_pace'], 2) ?> km/h
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary" 
                                                onclick="showMap(<?= htmlspecialchars($activity['gps_route']) ?>)">
                                            <i class="fas fa-map-marked-alt"></i> Lihat
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada aktivitas</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Map Modal -->
<div class="modal fade" id="mapModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-map me-2"></i> GPS Route</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="map" style="height: 400px;"></div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
// Progress Chart
const progressData = <?= json_encode($chart_data ?? ['labels' => [], 'distances' => [], 'calories' => []]) ?>;

const ctx = document.getElementById('progressChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: progressData.labels,
        datasets: [
            {
                label: 'Jarak (km)',
                data: progressData.distances,
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4
            },
            {
                label: 'Kalori',
                data: progressData.calories,
                borderColor: '#f59e0b',
                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                tension: 0.4,
                yAxisID: 'y1'
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                position: 'left'
            },
            y1: {
                beginAtZero: true,
                position: 'right',
                grid: {
                    drawOnChartArea: false
                }
            }
        }
    }
});

// Map Modal
let map = null;

function showMap(gpsRoute) {
    const modal = new bootstrap.Modal(document.getElementById('mapModal'));
    modal.show();
    
    setTimeout(() => {
        if (map) {
            map.remove();
        }
        
        map = L.map('map').setView([gpsRoute[0].lat, gpsRoute[0].lng], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);
        
        const latlngs = gpsRoute.map(point => [point.lat, point.lng]);
        L.polyline(latlngs, {color: '#667eea', weight: 5}).addTo(map);
        
        L.marker([gpsRoute[0].lat, gpsRoute[0].lng])
            .addTo(map)
            .bindPopup('Start');
        
        L.marker([gpsRoute[gpsRoute.length - 1].lat, gpsRoute[gpsRoute.length - 1].lng])
            .addTo(map)
            .bindPopup('Finish');
    }, 300);
}
</script>
<?php $this->endSection(); ?>