<?php
$this->extend('layouts/main');
$this->section('content');
?>

<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Main Welcome Card -->
                <div class="card shadow-lg border-0 mb-4">
                    <!-- CTA Buttons -->
                    <div class="d-flex justify-content-end gap-3 m-4">
                        <a href="<?= base_url('login') ?>" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                        <a href="<?= base_url('register') ?>" class="btn btn-outline-primary btn-lg px-5">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </a>
                    </div>
                    <div class="card-body p-5 text-center">
                        <div class="mb-4">
                            <i class="fas fa-running fa-5x mb-3"></i>
                            <h1 class="display-4 fw-bold mb-3">Welcome to Training Tracking App</h1>
                            <p class="lead text-muted mb-4">
                                Your Personal Fitness Journey Companion
                            </p>
                        </div>

                        <!-- App Description -->
                        <div class="text-center mb-4">
                            <h3 class="mb-3"><i class="fas fa-info-circle text-info me-2"></i>About This Application</h3>
                            <p class="text-muted">
                                The Training Tracking App is a comprehensive fitness monitoring platform designed to help you track, 
                                analyze, and optimize your training activities. Built with modern web technologies, this application 
                                provides real-time GPS tracking, detailed analytics, and personalized health insights.
                            </p>
                        </div>

                        <!-- Key Features -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body">
                                        <i class="fas fa-map-marked-alt fa-2x text-primary mb-3"></i>
                                        <h5>GPS Tracking</h5>
                                        <p class="text-muted small mb-0">
                                            Track your running and walking activities with real-time GPS route mapping powered by Leaflet.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body">
                                        <i class="fas fa-chart-line fa-2x text-success mb-3"></i>
                                        <h5>Performance Analytics</h5>
                                        <p class="text-muted small mb-0">
                                            View comprehensive statistics including distance, duration, pace, and training history with interactive charts.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body">
                                        <i class="fas fa-weight fa-2x text-warning mb-3"></i>
                                        <h5>BMI Calculator</h5>
                                        <p class="text-muted small mb-0">
                                            Monitor your Body Mass Index with automated alerts for health categories and personalized recommendations.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body">
                                        <i class="fas fa-bell fa-2x text-danger mb-3"></i>
                                        <h5>Smart Notifications</h5>
                                        <p class="text-muted small mb-0">
                                            Receive timely alerts for inactive periods (7+ days), BMI changes, and motivational reminders.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body">
                                        <i class="fas fa-file-pdf fa-2x text-info mb-3"></i>
                                        <h5>Export Reports</h5>
                                        <p class="text-muted small mb-0">
                                            Generate and download detailed PDF reports of your training activities and progress.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body">
                                        <i class="fas fa-user-shield fa-2x text-secondary mb-3"></i>
                                        <h5>Admin Monitoring</h5>
                                        <p class="text-muted small mb-0">
                                            Dedicated admin panel for managing users, monitoring activities, and analyzing overall platform usage.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Roles -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <div class="stat-card primary text-center">
                                    <i class="fas fa-user fa-3x mb-3"></i>
                                    <h4>For Users</h4>
                                    <ul class="list-unstyled text-start mt-3">
                                        <li><i class="fas fa-check me-2"></i>Personal dashboard with training overview</li>
                                        <li><i class="fas fa-check me-2"></i>Start and track training sessions</li>
                                        <li><i class="fas fa-check me-2"></i>View complete training history</li>
                                        <li><i class="fas fa-check me-2"></i>Receive health notifications</li>
                                        <li><i class="fas fa-check me-2"></i>Monitor physical data and BMI</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="stat-card success text-center">
                                    <i class="fas fa-user-tie fa-3x mb-3"></i>
                                    <h4>For Admins</h4>
                                    <ul class="list-unstyled text-start mt-3">
                                        <li><i class="fas fa-check me-2"></i>Comprehensive admin dashboard</li>
                                        <li><i class="fas fa-check me-2"></i>User management and monitoring</li>
                                        <li><i class="fas fa-check me-2"></i>Physical data management for users</li>
                                        <li><i class="fas fa-check me-2"></i>Export detailed reports</li>
                                        <li><i class="fas fa-check me-2"></i>View activity logs and analytics</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Technology Stack -->
                        <div class="mb-4">
                            <h5 class="mb-3"><i class="fas fa-code text-primary me-2"></i>Built With Modern Technology</h5>
                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                <span class="badge bg-primary p-2">CodeIgniter 4</span>
                                <span class="badge bg-secondary p-2">PHP 8+</span>
                                <span class="badge bg-success p-2">Bootstrap 5</span>
                                <span class="badge bg-info p-2">Chart.js</span>
                                <span class="badge bg-warning text-dark p-2">Leaflet Maps</span>
                                <span class="badge bg-danger p-2">MySQL</span>
                                <span class="badge bg-dark p-2">Dompdf</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="text-center text-white">
                    <p class="mb-2">
                        <i class="fas fa-shield-alt me-2"></i>
                        Secure · Private · User-Friendly
                    </p>
                    <p class="small opacity-75">
                        © <?= date('Y') ?> Training Tracking App. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>