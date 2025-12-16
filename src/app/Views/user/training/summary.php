<?php
// filepath: app/Views/user/training/summary.php
$this->extend('layouts/user_layout');
$this->section('page_content');
?>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('user/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('user/history') ?>">Riwayat</a></li>
                <li class="breadcrumb-item active">Summary Training</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">
                    <i class="fas fa-trophy me-2 text-warning"></i> Training Summary
                </h2>
                <p class="text-muted mb-0">
                    <?= date('d F Y, H:i', strtotime($activity['activity_date'])) ?>
                </p>
            </div>
            <a href="<?= base_url('user/history') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>
    
    <!-- Success Alert -->
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle fa-2x me-3"></i>
            <div>
                <h5 class="alert-heading mb-1">Training Berhasil Disimpan!</h5>
                <p class="mb-0">Selamat! Kamu telah menyelesaikan training hari ini 💪</p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    
    <!-- Main Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-route fa-3x text-primary mb-3"></i>
                    <h2 class="display-5 mb-0"><?= number_format($activity['distance'], 2) ?></h2>
                    <p class="text-muted mb-0">Jarak (km)</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-clock fa-3x text-info mb-3"></i>
                    <h2 class="display-5 mb-0"><?= gmdate('H:i:s', $activity['duration']) ?></h2>
                    <p class="text-muted mb-0">Durasi</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-tachometer-alt fa-3x text-success mb-3"></i>
                    <h2 class="display-5 mb-0"><?= number_format($activity['avg_speed'], 2) ?></h2>
                    <p class="text-muted mb-0">Kecepatan (km/h)</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-fire fa-3x text-warning mb-3"></i>
                    <h2 class="display-5 mb-0"><?= number_format($activity['calories_burned']) ?></h2>
                    <p class="text-muted mb-0">Kalori (kcal)</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Map & Additional Info -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i> Route Map</h5>
                </div>
                <div class="card-body p-0">
                    <div id="map" style="height: 450px; width: 100%;"></div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Performance Analysis -->
            <div class="card mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i> Performance</h5>
                </div>
                <div class="card-body">
                    <?php
                    $pace = $activity['distance'] > 0 ? ($activity['duration'] / 60) / $activity['distance'] : 0;
                    $maxSpeed = $activity['avg_speed'] * 1.2; // Estimate
                    ?>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Pace (min/km)</span>
                            <strong><?= number_format($pace, 2) ?></strong>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" style="width: <?= min($pace * 10, 100) ?>%"></div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Max Speed (km/h)</span>
                            <strong><?= number_format($maxSpeed, 2) ?></strong>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: <?= min($maxSpeed * 5, 100) ?>%"></div>
                        </div>
                    </div>
                    
                    <div class="mb-0">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Efficiency</span>
                            <strong><?= $activity['avg_speed'] > 8 ? 'Excellent' : ($activity['avg_speed'] > 6 ? 'Good' : 'Fair') ?></strong>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-<?= $activity['avg_speed'] > 8 ? 'success' : ($activity['avg_speed'] > 6 ? 'warning' : 'danger') ?>" 
                                 style="width: <?= min($activity['avg_speed'] * 10, 100) ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Achievements -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-medal me-2"></i> Achievements</h5>
                </div>
                <div class="card-body">
                    <?php if ($activity['distance'] >= 5): ?>
                        <div class="alert alert-warning mb-2">
                            <i class="fas fa-trophy me-2"></i>
                            <strong>5K Runner!</strong>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($activity['avg_speed'] >= 10): ?>
                        <div class="alert alert-success mb-2">
                            <i class="fas fa-bolt me-2"></i>
                            <strong>Speed Demon!</strong>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($activity['calories_burned'] >= 500): ?>
                        <div class="alert alert-danger mb-2">
                            <i class="fas fa-fire me-2"></i>
                            <strong>Calorie Burner!</strong>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (empty($activity['distance'] >= 5) && empty($activity['avg_speed'] >= 10) && empty($activity['calories_burned'] >= 500)): ?>
                        <p class="text-muted text-center mb-0">
                            <i class="fas fa-star"></i><br>
                            Keep training to unlock achievements!
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Share & Actions -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">Bagikan Pencapaian Kamu!</h5>
                    <p class="text-muted mb-0">Share training summary ke social media</p>
                </div>
                <div class="btn-group">
                    <button class="btn btn-primary" onclick="shareToTwitter()">
                        <i class="fab fa-twitter me-2"></i> Twitter
                    </button>
                    <button class="btn btn-success" onclick="shareToWhatsApp()">
                        <i class="fab fa-whatsapp me-2"></i> WhatsApp
                    </button>
                    <a href="<?= base_url('user/training/start') ?>" class="btn btn-warning">
                        <i class="fas fa-redo me-2"></i> Training Lagi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
// Initialize Map
const gpsRoute = <?= $activity['gps_route'] ?>;

const map = L.map('map');

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

if (gpsRoute && gpsRoute.length > 0) {
    // Draw route
    const latlngs = gpsRoute.map(point => [point.lat, point.lng]);
    const polyline = L.polyline(latlngs, {
        color: '#667eea',
        weight: 5,
        opacity: 0.8
    }).addTo(map);
    
    // Fit bounds
    map.fitBounds(polyline.getBounds());
    
    // Add markers
    L.marker([gpsRoute[0].lat, gpsRoute[0].lng])
        .addTo(map)
        .bindPopup('<strong>Start</strong>')
        .openPopup();
    
    L.marker([gpsRoute[gpsRoute.length - 1].lat, gpsRoute[gpsRoute.length - 1].lng])
        .addTo(map)
        .bindPopup('<strong>Finish</strong>');
} else {
    map.setView([-6.2088, 106.8456], 13);
}

// Share Functions
function shareToTwitter() {
    const text = `Baru saja menyelesaikan training ${<?= $activity['distance'] ?>} km dalam ${<?= gmdate('H:i:s', $activity['duration']) ?>}! 💪 #TrackingApp`;
    window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}`, '_blank');
}

function shareToWhatsApp() {
    const text = `🏃 Baru saja menyelesaikan training!\n\n📍 Jarak: ${<?= $activity['distance'] ?>} km\n⏱️ Durasi: ${<?= gmdate('H:i:s', $activity['duration']) ?>}\n🔥 Kalori: ${<?= $activity['calories_burned'] ?>} kcal\n\nYuk ikutan training!`;
    window.open(`https://wa.me/?text=${encodeURIComponent(text)}`, '_blank');
}
</script>
<?php $this->endSection(); ?>