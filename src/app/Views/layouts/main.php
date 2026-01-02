<?php
// filepath: app/Views/layouts/main.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Training Tracking Application">
    <title><?= $title ?? 'Tracking App' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    
    <!-- Leaflet CSS (untuk maps) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- Custom CSS -->
    <style>
        :root {
            --bs-primary: #FC4C02;
            --bs-info: #FF8C42;
            --bs-success: #22C55E;
            --bs-danger: #EF4444;
            --bs-warning: #F59E0B;
            --bs-dark: #0F172A;
            --bs-light: #F8FAFC;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-color);
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-info) 100%);
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        .icon-container {
            border: 2px solid var(--bs-primary);
            border-radius: 10px;
            padding: 1rem;
        }

        .icon-large {
            font-size: 3rem;
        }

        .btn-primary {
            --bs-btn-color: #ffffff;
            --bs-btn-bg: var(--bs-primary);
            --bs-btn-border-color: none;
            --bs-btn-hover-bg: var(--bs-primary);
            --bs-btn-hover-color: #ffffff;
            --bs-btn-active-bg: var(--bs-info);
            --bs-btn-active-border-color: var(--bs-primary);
        }
        
        .btn-outline-primary {
            --bs-btn-color: var(--bs-primary);
            --bs-btn-border-color: var(--bs-primary);
            --bs-btn-hover-bg: var(--bs-info);
            --bs-btn-hover-color: #ffffff;
            --bs-btn-hover-border-color: var(--bs-primary);
            --bs-btn-active-bg: var(--bs-info);
            --bs-btn-active-border-color: var(--bs-primary);
        }

        .btn-primary:hover {
            background: var(--bs-info);
        }

        .text-primary {
            color: var(--bs-primary);
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            overflow-y: auto;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link {
            color: var(--dark-color);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 5px 10px;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: var(--bs-primary);
            color: white;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }
        
        .stat-card {
            padding: 20px;
            border-radius: 10px;
            color: white;
            margin-bottom: 20px;
        } 
        
        .stat-card.primary { background: var(--bs-primary) }
        .stat-card.success { background: var(--bs-success) }
        .stat-card.warning { background: var(--bs-warning) }
        .stat-card.danger { background: var(--bs-danger) }
        
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
                z-index: 1050;
            }
            
            .sidebar.show {
                margin-left: 0;
                z-index: 1050;
            }
            
            .main-content {
                margin-left: 0;
                z-index: 1;
            }
        }
    </style>
    
    <!-- Additional CSS -->
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <!-- Content -->
    <?= $this->renderSection('content') ?>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Leaflet JS (untuk maps) -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <!-- jQuery (optional, untuk AJAX) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Additional JS -->
    <?= $this->renderSection('scripts') ?>

</body>
</html>