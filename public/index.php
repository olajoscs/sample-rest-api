<?php

define('APP_START', microtime(true));
define('ROOT', __DIR__ . '/..');

$displayErrors = true;
$reportLevel   = E_ALL;

// Including my helper function collection
require ROOT . '/bootstrap/helper.php';
require ROOT . '/vendor/autoload.php';

// Creating config based on .env file
$config = require ROOT . '/config/config.php';

// Changing most important php.ini values
if (evaluate($config['error']['display']) !== true) {
    $displayErrors = false;
    $reportLevel   = 0;
}

// Setting most important php.ini values
ini_set('display_errors', $displayErrors);
ini_set('error_reporting', $reportLevel);
ini_set('display_startup_errors', $displayErrors);

// Creating the Slim app
$app = new \Slim\App([
    'settings' => array_merge(
        $config,
        [
            'displayErrorDetails' => $displayErrors
        ]
    )
]);

// Including dependencies
require ROOT . '/bootstrap/dependencies.php';

// Including the routes
require ROOT . '/bootstrap/routes.php';

// Fire
$app->run();
