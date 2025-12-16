<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class TestRoutesCommand extends BaseCommand
{
    protected $group       = 'app';
    protected $name        = 'test:routes';
    protected $description = 'Test all routes configuration';

    public function run(array $params)
    {
        $routes = \Config\Services::routes();
        $collection = $routes->getRoutes();

        CLI::write('=== REGISTERED ROUTES ===', 'yellow');
        CLI::newLine();

        foreach ($collection as $route => $handler) {
            CLI::write("Route: {$route}", 'green');
            CLI::write("Handler: {$handler}", 'white');
            CLI::newLine();
        }

        CLI::write('Total routes: ' . count($collection), 'yellow');
    }
}