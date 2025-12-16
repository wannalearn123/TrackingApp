<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================================
// PUBLIC ROUTES (Accessible without login)
// ============================================

$routes->get('/', 'Home::index');

// Authentication Routes
$routes->group('', ['namespace' => 'App\Controllers\Auth'], function($routes) {
    // Login
    $routes->get('login', 'LoginController::index');
    $routes->post('login/authenticate', 'LoginController::authenticate');
    
    // Register
    $routes->get('register', 'RegisterController::index');
    $routes->post('register/store', 'RegisterController::store');
    
    // Waiting Approval
    $routes->get('waiting-approval', 'RegisterController::waitingApproval');
    
    // Logout
    $routes->get('logout', 'LogoutController::index');
});

// ============================================
// ADMIN ROUTES (Requires admin role)
// ============================================

$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'admin'], function($routes) {
    
    // Dashboard
    $routes->get('dashboard', 'DashboardController::index');
    
    // User Management
    $routes->group('users', function($routes) {
        $routes->get('/', 'UserManagementController::index');
        $routes->get('approve/(:num)', 'UserManagementController::approve/$1');
        $routes->get('deactivate/(:num)', 'UserManagementController::deactivate/$1');
        $routes->get('activate/(:num)', 'UserManagementController::activate/$1');
        $routes->post('delete/(:num)', 'UserManagementController::delete/$1');
    });
    
    // Physical Data Management
    $routes->group('physical-data', function($routes) {
        $routes->get('create/(:num)', 'PhysicalDataController::create/$1');
        $routes->post('store', 'PhysicalDataController::store');
        $routes->post('update/(:num)', 'PhysicalDataController::update/$1');
    });
    
    // Monitoring
    $routes->group('monitoring', function($routes) {
        $routes->get('/', 'MonitoringController::index');
        $routes->get('user/(:num)', 'MonitoringController::userDetail/$1');
    });
    
    // Report Export
    $routes->get('export/dashboard', 'ReportExportController::exportDashboard');
});

// ============================================
// USER ROUTES (Requires user role)
// ============================================

$routes->group('user', ['namespace' => 'App\Controllers\User', 'filter' => 'user'], function($routes) {
    
    // Dashboard
    $routes->get('dashboard', 'DashboardController::index');
    
    // Training
    $routes->group('training', function($routes) {
        $routes->get('start', 'TrainingController::start');
        $routes->post('save', 'TrainingController::save');
        $routes->get('summary/(:num)', 'TrainingController::summary/$1');
    });
    
    // History
    $routes->group('history', function($routes) {
        $routes->get('/', 'HistoryController::index');
        $routes->get('detail/(:num)', 'HistoryController::detail/$1');
        $routes->post('delete/(:num)', 'HistoryController::delete/$1');
    });
    
    // Notifications
    $routes->group('notifications', function($routes) {
        $routes->get('/', 'NotificationController::index');
        $routes->post('mark-read/(:num)', 'NotificationController::markAsRead/$1');
        $routes->post('mark-all-read', 'NotificationController::markAllAsRead');
        $routes->get('unread-count', 'NotificationController::getUnreadCount');
    });
});