<?php
// filepath: app/Views/user/notifications.php
$this->extend('layouts/user_layout');
$this->section('page_content');
include_once APPPATH . 'Helpers/Time_helper.php';
?>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">
                    <i class="fas fa-bell me-2"></i> Notifikasi
                </h2>
                <p class="text-muted mb-0">
                    <?= $unreadCount ?> notifikasi belum dibaca
                </p>
            </div>
            <?php if ($unreadCount > 0): ?>
                <form method="POST" action="<?= base_url('user/notifications/mark-all-read') ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-check-double me-2"></i> Tandai Semua Dibaca
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#all" type="button">
                <i class="fas fa-list me-2"></i> Semua (<?= count($notifications ?? []) ?>)
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#unread" type="button">
                <i class="fas fa-envelope me-2"></i> Belum Dibaca (<?= $unreadCount ?>)
            </button>
        </li>
    </ul>
    
    <!-- Tab Content -->
    <div class="tab-content">
        <!-- All Notifications -->
        <div class="tab-pane fade show active" id="all">
            <?php if (!empty($notifications)): ?>
                <div class="list-group">
                    <?php foreach ($notifications as $notif): ?>
                        <div class="list-group-item list-group-item-action <?= !$notif['is_read'] ? 'bg-light' : '' ?>">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <?php
                                        $iconClass = 'fa-info-circle text-primary';
                                        if ($notif['type'] === 'goal_achieved') {
                                            $iconClass = 'fa-trophy text-warning';
                                        } elseif ($notif['type'] === 'reminder') {
                                            $iconClass = 'fa-bell text-info';
                                        } elseif ($notif['type'] === 'warning') {
                                            $iconClass = 'fa-exclamation-triangle text-danger';
                                        }
                                        ?>
                                        <i class="fas <?= $iconClass ?> fa-2x me-3"></i>
                                        <div>
                                            <h6 class="mb-1"><?= esc($notif['title']) ?></h6>
                                            <p class="mb-0 text-muted"><?= esc($notif['message']) ?></p>
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        <?= time_ago($notif['created_at']) ?>
                                    </small>
                                </div>
                                <div class="ms-3">
                                    <?php if (!$notif['is_read']): ?>
                                        <form method="POST" action="<?= base_url('user/notifications/mark-read/' . $notif['id']) ?>" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-primary" title="Tandai Dibaca">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check"></i> Dibaca
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Pagination -->
                <?php if (!empty($pager)): ?>
                    <div class="mt-4">
                        <?= $pager->links() ?>
                    </div>
                <?php endif; ?>
                
            <?php else: ?>
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-inbox fa-5x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum Ada Notifikasi</h5>
                        <p class="text-muted">Notifikasi akan muncul di sini</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Unread Notifications -->
        <div class="tab-pane fade" id="unread">
            <?php
            $unread_notifications = array_filter($notifications ?? [], fn($n) => !$n['is_read']);
            ?>
            
            <?php if (!empty($unread_notifications)): ?>
                <div class="list-group">
                    <?php foreach ($unread_notifications as $notif): ?>
                        <div class="list-group-item list-group-item-action bg-light">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <?php
                                        $iconClass = 'fa-info-circle text-primary';
                                        if ($notif['type'] === 'goal_achieved') {
                                            $iconClass = 'fa-trophy text-warning';
                                        } elseif ($notif['type'] === 'reminder') {
                                            $iconClass = 'fa-bell text-info';
                                        } elseif ($notif['type'] === 'warning') {
                                            $iconClass = 'fa-exclamation-triangle text-danger';
                                        }
                                        ?>
                                        <i class="fas <?= $iconClass ?> fa-2x me-3"></i>
                                        <div>
                                            <h6 class="mb-1"><?= esc($notif['title']) ?></h6>
                                            <p class="mb-0 text-muted"><?= esc($notif['message']) ?></p>
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        <?= time_ago($notif['created_at']) ?>
                                    </small>
                                </div>
                                <div class="ms-3">
                                    <form method="POST" action="<?= base_url('user/notifications/mark-read/' . $notif['id']) ?>" class="d-inline">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-primary" title="Tandai Dibaca">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-check-circle fa-5x text-success mb-3"></i>
                        <h5 class="text-muted">Semua Notifikasi Sudah Dibaca</h5>
                        <p class="text-muted">Kamu sudah up to date! 👍</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
// Auto refresh unread count
setInterval(function() {
    fetch('<?= base_url('user/notifications/unread-count') ?>')
        .then(response => response.json())
        .then(data => {
            if (data.count > 0) {
                document.title = `(${data.count}) Notifikasi - Tracking App`;
            } else {
                document.title = 'Notifikasi - Tracking App';
            }
        });
}, 30000); // Check every 30 seconds
</script>
<?php $this->endSection(); ?>