<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class TestRoutingCommand extends BaseCommand
{
    protected $group       = 'app';
    protected $name        = 'test:routing';
    protected $description = 'Test all routing configuration';

    public function run(array $params)
    {
        CLI::write('=== TESTING ROUTING ===', 'yellow');
        CLI::newLine();

        // Test 1: Count routes
        $routes = \Config\Services::routes();
        $routes->loadRoutes();
        $collection = $routes->getRoutes();
        
        CLI::write('Total routes: ' . count($collection), 'green');
        CLI::newLine();

        // Test 2: Check critical routes
        $criticalRoutes = [
            '/',
            'login',
            'admin/dashboard',
            'user/dashboard',
        ];

        CLI::write('Checking critical routes:', 'yellow');
        foreach ($criticalRoutes as $route) {
            $exists = isset($collection[$route]);
            $status = $exists ? '✓' : '✗';
            $color = $exists ? 'green' : 'red';
            CLI::write("  {$status} {$route}", $color);
        }

        CLI::newLine();
        CLI::write('Routing test complete!', 'green');
    }
}