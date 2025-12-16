<?php

namespace Config;

use CodeIgniter\Config\Routing as BaseRouting;

class Routing extends BaseRouting
{
    /**
     * Default Namespace
     *
     * @var string
     */
    public string $defaultNamespace = 'App\Controllers';

    /**
     * Default Controller
     *
     * @var string
     */
    public string $defaultController = 'Home';

    /**
     * Default Method
     *
     * @var string
     */
    public string $defaultMethod = 'index';

    /**
     * Translate URI dashes
     *
     * @var bool
     */
    public bool $translateURIDashes = false;

    /**
     * Override HTTP
     *
     * @var bool
     */
    public bool $overrideHTTP = false;

    /**
     * Auto Route
     *
     * @var bool
     */
    public bool $autoRoute = false; // PENTING: Set false untuk security

    /**
     * 404 Override
     *
     * @var string|null
     */
    public ?string $override404 = null;

    /**
     * Prioritize
     *
     * @var bool
     */
    public bool $prioritize = false;
}