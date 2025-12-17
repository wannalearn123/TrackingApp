<?php
// filepath: app/Views/admin/users/physical_data_form.php
$this->extend('layouts/admin_layout');
$this->section('page_content');
?>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>">Manajemen User</a></li>
                <li class="breadcrumb-item active">Input Data Fisik</li>
            </ol>
        </nav>
        <h2 class="mb-1">
            <i class="fas fa-weight me-2"></i> 
            <?= isset($physical_data) ? 'Update' : 'Input' ?> Data Fisik
        </h2>
        <p class="text-muted mb-0">
            User: <strong><?= esc($user['username']) ?></strong> (<?= esc($user['email']) ?>)
        </p>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i> Form Data Fisik</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= isset($physicalData) ? base_url('admin/physical-data/update/' . $physicalData['id']) : base_url('admin/physical-data/store') ?>">
                        <?= csrf_field() ?>
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="height" class="form-label">
                                    <i class="fas fa-ruler-vertical me-1"></i> Tinggi Badan (cm)
                                </label>
                                <input type="number" step="0.1" 
                                       class="form-control <?= isset($errors['height']) ? 'is-invalid' : '' ?>" 
                                       id="height" name="height" 
                                       value="<?= old('height', $physicalData['height'] ?? '') ?>" 
                                       placeholder="Contoh: 170" required>
                                <?php if (isset($errors['height'])): ?>
                                    <div class="invalid-feedback"><?= $errors['height'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="weight" class="form-label">
                                    <i class="fas fa-weight me-1"></i> Berat Badan (kg)
                                </label>
                                <input type="number" step="0.1" 
                                       class="form-control <?= isset($errors['weight']) ? 'is-invalid' : '' ?>" 
                                       id="weight" name="weight" 
                                       value="<?= old('weight', $physicalData['weight'] ?? '') ?>" 
                                       placeholder="Contoh: 65" required>
                                <?php if (isset($errors['weight'])): ?>
                                    <div class="invalid-feedback"><?= $errors['weight'] ?></div>
                                <?php endif; ?>
                            </div>                         
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> 
                                <?= isset($physicalData) ? 'Update' : 'Simpan' ?> Data
                            </button>
                            <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- BMI Calculator Preview -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-calculator me-2"></i> BMI Calculator</h5>
                </div>
                <div class="card-body text-center">
                    <div id="bmiResult" class="mb-3">
                        <h2 class="display-4 mb-0">-</h2>
                        <p class="text-muted mb-0">BMI Value</p>
                    </div>
                    <div id="bmiCategory" class="alert alert-secondary">
                        <strong>Masukkan tinggi & berat untuk kalkulasi</strong>
                    </div>
                    
                    <hr>
                    
                    <h6 class="mb-3">Kategori BMI:</h6>
                    <div class="text-start small">
                        <div class="mb-2">
                            <span class="badge bg-info">Underweight</span> &lt; 18.5
                        </div>
                        <div class="mb-2">
                            <span class="badge bg-success">Normal</span> 18.5 - 24.9
                        </div>
                        <div class="mb-2">
                            <span class="badge bg-warning">Overweight</span> 25 - 29.9
                        </div>
                        <div class="mb-2">
                            <span class="badge bg-danger">Obese</span> ≥ 30
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
// Real-time BMI Calculator
function calculateBMI() {
    const height = parseFloat(document.getElementById('height').value);
    const weight = parseFloat(document.getElementById('weight').value);
    
    if (height > 0 && weight > 0) {
        const heightInMeters = height / 100;
        const bmi = weight / (heightInMeters * heightInMeters);
        
        document.getElementById('bmiResult').innerHTML = `
            <h2 class="display-4 mb-0">${bmi.toFixed(1)}</h2>
            <p class="text-muted mb-0">BMI Value</p>
        `;
        
        let category = '';
        let alertClass = '';
        
        if (bmi < 18.5) {
            category = 'Underweight';
            alertClass = 'alert-info';
        } else if (bmi >= 18.5 && bmi < 25) {
            category = 'Normal';
            alertClass = 'alert-success';
        } else if (bmi >= 25 && bmi < 30) {
            category = 'Overweight';
            alertClass = 'alert-warning';
        } else {
            category = 'Obese';
            alertClass = 'alert-danger';
        }
        
        document.getElementById('bmiCategory').className = `alert ${alertClass}`;
        document.getElementById('bmiCategory').innerHTML = `<strong>${category}</strong>`;
    }
}

document.getElementById('height').addEventListener('input', calculateBMI);
document.getElementById('weight').addEventListener('input', calculateBMI);

// Calculate on page load if data exists
window.addEventListener('load', calculateBMI);
</script>
<?php $this->endSection(); ?>