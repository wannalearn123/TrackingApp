<?php
// filepath: app/Views/user/training/start.php
$this->extend('layouts/user_layout');
$this->section('page_content');
?>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="mb-1">
            <i class="fas fa-play-circle me-2"></i> Mulai Training
        </h2>
        <p class="text-muted mb-0">
            Track aktivitas lari/jalan kamu dengan GPS
        </p>
    </div>
    
    <?php if (empty($physicalData)): ?>
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Data fisik belum diinput!</strong> Hubungi admin untuk input data fisik agar tracking lebih akurat.
        </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-8">
            <!-- Map -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i> GPS Tracking</h5>
                </div>
                <div class="card-body p-0">
                    <div id="map" style="height: 500px; width: 100%;"></div>
                </div>
            </div>
            
            <!-- Control Buttons -->
            <div class="card">
                <div class="card-body text-center">
                    <button id="startBtn" class="btn btn-success btn-lg px-5" onclick="startTracking()">
                        <i class="fas fa-play me-2"></i> Mulai Training
                    </button>
                    <button id="stopBtn" class="btn btn-danger btn-lg px-5 d-none" onclick="stopTracking()">
                        <i class="fas fa-stop me-2"></i> Stop Training
                    </button>
                    <button id="pauseBtn" class="btn btn-warning btn-lg px-4 d-none" onclick="pauseTracking()">
                        <i class="fas fa-pause me-2"></i> Pause
                    </button>
                    <button id="resumeBtn" class="btn btn-info btn-lg px-4 d-none" onclick="resumeTracking()">
                        <i class="fas fa-play me-2"></i> Resume
                    </button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Live Stats -->
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-tachometer-alt me-2"></i> Live Stats</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4 text-center">
                        <div id="timer" class="display-3 fw-bold text-primary">00:00:00</div>
                        <p class="text-muted mb-0">Durasi</p>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded text-center">
                                <h4 class="mb-0" id="distance">0.00</h4>
                                <small class="text-muted">Jarak (km)</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded text-center">
                                <h4 class="mb-0" id="avgSpeed">0.00</h4>
                                <small class="text-muted">Kecepatan (km/h)</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded text-center">
                                <h4 class="mb-0" id="currentSpeed">0.00</h4>
                                <small class="text-muted">Speed Saat Ini</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded text-center">
                                <h4 class="mb-0" id="calories">0</h4>
                                <small class="text-muted">Kalori (kcal)</small>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="alert alert-info">
                        <small>
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Tips:</strong> Pastikan GPS aktif dan kamu berada di area terbuka untuk tracking yang akurat.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Save Confirmation Modal -->
<div class="modal fade" id="saveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-save me-2"></i> Simpan Training</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="saveForm" method="POST" action="<?= base_url('user/training/save') ?>">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="distance" id="saveDistance">
                    <input type="hidden" name="duration" id="saveDuration">
                    <input type="hidden" name="gps_route" id="saveGpsRoute">
                    <input type="hidden" name="calories_burned" id="saveCalories">
                    <input type="hidden" name="avg_speed" id="saveAvgSpeed">
                    
                    <h6>Summary Training:</h6>
                    <table class="table table-borderless">
                        <tr>
                            <td>Jarak:</td>
                            <td class="text-end"><strong id="summaryDistance">-</strong></td>
                        </tr>
                        <tr>
                            <td>Durasi:</td>
                            <td class="text-end"><strong id="summaryDuration">-</strong></td>
                        </tr>
                        <tr>
                            <td>Kecepatan Rata-rata:</td>
                            <td class="text-end"><strong id="summarySpeed">-</strong></td>
                        </tr>
                        <tr>
                            <td>Kalori:</td>
                            <td class="text-end"><strong id="summaryCalories">-</strong></td>
                        </tr>
                    </table>
                    
                    <p class="text-muted small mb-0">
                        <i class="fas fa-check-circle me-1"></i>
                        Data training akan disimpan ke database
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
// Training Variables
let map, marker, polyline;
let gpsRoute = [];
let startTime, elapsedTime = 0, timerInterval;
let isPaused = false, isRunning = false;
let lastPosition = null;
let totalDistance = 0;

// User Physical Data
const userWeight = <?= $physical_data['weight'] ?? 70 ?>;

// Initialize Map
function initMap() {
    map = L.map('map').setView([-6.2088, 106.8456], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Get current location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            map.setView([lat, lng], 15);
            
            marker = L.marker([lat, lng]).addTo(map);
        });
    }
}

// Start Tracking
function startTracking() {
    if (!navigator.geolocation) {
        alert('GPS tidak didukung di browser ini!');
        return;
    }
    
    isRunning = true;
    isPaused = false;
    startTime = Date.now();
    gpsRoute = [];
    totalDistance = 0;
    
    document.getElementById('startBtn').classList.add('d-none');
    document.getElementById('stopBtn').classList.remove('d-none');
    document.getElementById('pauseBtn').classList.remove('d-none');
    
    // Start timer
    timerInterval = setInterval(updateTimer, 1000);
    
    // Start GPS tracking
    watchId = navigator.geolocation.watchPosition(
        updatePosition,
        handleError,
        { enableHighAccuracy: true, maximumAge: 0 }
    );
}

// Update Position
function updatePosition(position) {
    if (isPaused) return;
    
    const lat = position.coords.latitude;
    const lng = position.coords.longitude;
    const speed = position.coords.speed || 0;
    
    // Add to route
    gpsRoute.push({ lat, lng, timestamp: Date.now() });
    
    // Update marker
    if (marker) {
        marker.setLatLng([lat, lng]);
    } else {
        marker = L.marker([lat, lng]).addTo(map);
    }
    
    // Draw polyline
    if (lastPosition) {
        if (!polyline) {
            polyline = L.polyline([[lastPosition.lat, lastPosition.lng], [lat, lng]], {
                color: '#667eea',
                weight: 5
            }).addTo(map);
        } else {
            polyline.addLatLng([lat, lng]);
        }
        
        // Calculate distance
        const dist = calculateDistance(lastPosition.lat, lastPosition.lng, lat, lng);
        totalDistance += dist;
    }
    
    lastPosition = { lat, lng };
    
    // Update UI
    updateStats(speed);
    map.setView([lat, lng]);
}

// Update Stats
function updateStats(currentSpeed) {
    const speedKmh = (currentSpeed || 0) * 3.6;
    const duration = Math.floor((Date.now() - startTime) / 1000);
    const avgSpeed = duration > 0 ? (totalDistance / duration) * 3600 : 0;
    const calories = calculateCalories(totalDistance, userWeight);
    
    document.getElementById('distance').textContent = totalDistance.toFixed(2);
    document.getElementById('currentSpeed').textContent = speedKmh.toFixed(2);
    document.getElementById('avgSpeed').textContent = avgSpeed.toFixed(2);
    document.getElementById('calories').textContent = Math.round(calories);
}

// Calculate Distance (Haversine Formula)
function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; // Earth radius in km
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLon/2) * Math.sin(dLon/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}

// Calculate Calories
function calculateCalories(distance, weight) {
    const MET = 8.0; // Running MET value
    const hours = distance / 10; // Assume 10 km/h
    return MET * weight * hours;
}

// Update Timer
function updateTimer() {
    if (!isPaused && isRunning) {
        elapsedTime = Math.floor((Date.now() - startTime) / 1000);
        const hours = Math.floor(elapsedTime / 3600);
        const minutes = Math.floor((elapsedTime % 3600) / 60);
        const seconds = elapsedTime % 60;
        
        document.getElementById('timer').textContent = 
            `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }
}

// Pause Tracking
function pauseTracking() {
    isPaused = true;
    document.getElementById('pauseBtn').classList.add('d-none');
    document.getElementById('resumeBtn').classList.remove('d-none');
}

// Resume Tracking
function resumeTracking() {
    isPaused = false;
    document.getElementById('resumeBtn').classList.add('d-none');
    document.getElementById('pauseBtn').classList.remove('d-none');
}

// Stop Tracking
function stopTracking() {
    isRunning = false;
    clearInterval(timerInterval);
    navigator.geolocation.clearWatch(watchId);
    
    if (totalDistance < 0.1) {
        alert('Jarak terlalu pendek! Minimal 100 meter.');
        location.reload();
        return;
    }
    
    // Show save modal
    const duration = Math.floor((Date.now() - startTime) / 1000);
    const avgSpeed = (totalDistance / duration) * 3600;
    const calories = Math.round(calculateCalories(totalDistance, userWeight));
    
    document.getElementById('saveDistance').value = totalDistance.toFixed(2);
    document.getElementById('saveDuration').value = duration;
    document.getElementById('saveGpsRoute').value = JSON.stringify(gpsRoute);
    document.getElementById('saveCalories').value = calories;
    document.getElementById('saveAvgSpeed').value = avgSpeed.toFixed(2);
    
    document.getElementById('summaryDistance').textContent = totalDistance.toFixed(2) + ' km';
    document.getElementById('summaryDuration').textContent = document.getElementById('timer').textContent;
    document.getElementById('summarySpeed').textContent = avgSpeed.toFixed(2) + ' km/h';
    document.getElementById('summaryCalories').textContent = calories + ' kcal';
    
    new bootstrap.Modal(document.getElementById('saveModal')).show();
}

// Handle GPS Error
function handleError(error) {
    console.error('GPS Error:', error);
    alert('Error mengakses GPS: ' + error.message);
}

// Initialize on load
window.addEventListener('load', initMap);
</script>
<?php $this->endSection(); ?>