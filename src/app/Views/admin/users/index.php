<?php
// filepath: app/Views/admin/users/index.php
$this->extend('layouts/admin_layout');
$this->section('page_content');
?>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="mb-1"><i class="fas fa-users me-2"></i> Manajemen User</h2>
        <p class="text-muted mb-0">Kelola approval, aktivasi, dan data user</p>
    </div>
    
    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#approved" type="button">
                <i class="fas fa-check-circle me-2"></i> Approved Users (<?= count($users ?? []) ?>)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pending" type="button">
                <i class="fas fa-clock me-2"></i> Pending Approval (<?= count($pending_users ?? []) ?>)
            </button>
        </li>
    </ul>
    
    <!-- Tab Content -->
    <div class="tab-content">
        <!-- Approved Users Tab -->
        <div class="tab-pane fade show active" id="approved">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Data Fisik</th>
                                    <th>Terdaftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td>
                                                <i class="fas fa-user-circle me-2"></i>
                                                <strong><?= esc($user['username']) ?></strong>
                                            </td>
                                            <td><?= esc($user['email']) ?></td>
                                            <td>
                                                <?php if ($user['is_active']): ?>
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check"></i> Active
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-ban"></i> Inactive
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($user['bmi'])): ?>
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-check"></i> Sudah Input
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-exclamation"></i> Belum Input
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('admin/physical-data/create/' . $user['id']) ?>" 
                                                       class="btn btn-sm btn-primary" title="Input Data Fisik">
                                                        <i class="fas fa-weight"></i>
                                                    </a>
                                                    <a href="<?= base_url('admin/monitoring/user/' . $user['id']) ?>" 
                                                       class="btn btn-sm btn-info" title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <?php if ($user['is_active']): ?>
                                                        <a href="<?= base_url('admin/users/deactivate/' . $user['id']) ?>" 
                                                           class="btn btn-sm btn-warning" title="Deactivate"
                                                           onclick="return confirm('Yakin deactivate user ini?')">
                                                            <i class="fas fa-ban"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="<?= base_url('admin/users/activate/' . $user['id']) ?>" 
                                                           class="btn btn-sm btn-success" title="Activate">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <form method="POST" action="<?= base_url('admin/users/delete/' . $user['id']) ?>" 
                                                          style="display: inline;" 
                                                          onsubmit="return confirm('Yakin hapus user ini? Data tidak bisa dikembalikan!')">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Belum ada user approved</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pending Users Tab -->
        <div class="tab-pane fade" id="pending">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pending_users)): ?>
                                    <?php foreach ($pending_users as $user): ?>
                                        <tr>
                                            <td>
                                                <i class="fas fa-user-clock me-2"></i>
                                                <strong><?= esc($user['username']) ?></strong>
                                            </td>
                                            <td><?= esc($user['email']) ?></td>
                                            <td><?= date('d M Y H:i', strtotime($user['created_at'])) ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/users/approve/' . $user['id']) ?>" 
                                                   class="btn btn-sm btn-success" 
                                                   onclick="return confirm('Approve user <?= esc($user['username']) ?>?')">
                                                    <i class="fas fa-check me-1"></i> Approve
                                                </a>
                                                <form method="POST" action="<?= base_url('admin/users/delete/' . $user['id']) ?>" 
                                                      style="display: inline;" 
                                                      onsubmit="return confirm('Yakin tolak/hapus pendaftaran ini?')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-times me-1"></i> Tolak
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            <i class="fas fa-check-circle fa-3x mb-3 d-block text-success"></i>
                                            Tidak ada user yang menunggu approval
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>