<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ListRoutesCommand extends BaseCommand
{
    protected $group       = 'app';
    protected $name        = 'route:list';
    protected $description = 'List all registered routes';

    public function run(array $params)
    {
        $routes = \Config\Services::routes();
        $routes->loadRoutes();
        
        $collection = $routes->getRoutes();

        CLI::write('=== REGISTERED ROUTES ===', 'yellow');
        CLI::newLine();

        if (empty($collection)) {
            CLI::write('No routes found!', 'red');
            CLI::write('Check your app/Config/Routes.php file', 'yellow');
            return;
        }

        foreach ($collection as $route => $handler) {
            CLI::write("Route: {$route}", 'green');
            CLI::write("Handler: {$handler}", 'white');
            CLI::newLine();
        }

        CLI::write('Total routes: ' . count($collection), 'yellow');
    }
}