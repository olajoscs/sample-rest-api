<?php
/** @var \App\Core\App $app */

use App\Controllers\ProductController;
use App\Middlewares\Auth;

$app->add(new Auth($app->getContainer()));

$app->get('/products', ProductController::class . ':index')->setName('product.list');
$app->get('/products/{id:[\d]+}', ProductController::class . ':get')->setName('product.get');

$app->put('/products/{id}', ProductController::class . ':update')->setName('product.update');

$app->post('/products', ProductController::class . ':insert')->setName('product.insert');

$app->delete('/products/{id:[\d]+}', ProductController::class . ':delete')->setName('product.delete');

