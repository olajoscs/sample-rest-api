<?php


ini_set('display_errors', true);
error_reporting(E_ALL);
ini_set('max_execution_time', 600);

define('APP_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap/helper.php';

// Passing no settings here
$app = new \App\Core\App([]);

require __DIR__ . '/../bootstrap/dependencies.php';
require __DIR__ . '/../bootstrap/routes.php';

// TODO: HACK - Config fájl beolvasásának a force-olása
$app->getContainer()->config;

$app->run();
