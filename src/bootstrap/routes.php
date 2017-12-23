<?php
/** @var \App\Core\App $app */

use App\Controllers\CategoryController;
use App\Controllers\ProductController;
use App\Middlewares\Auth;
use App\Middlewares\Cors;

$app->add(new Auth($app->getContainer()));
$app->add(new Cors($app->getContainer()));

$app->get('/products', ProductController::class . ':index')->setName('product.list');
$app->get('/products/{id:[\d]+}', ProductController::class . ':get')->setName('product.get');
$app->put('/products/{id:[\d]+}', ProductController::class . ':update')->setName('product.update');
$app->post('/products', ProductController::class . ':insert')->setName('product.insert');
$app->delete('/products/{id:[\d]+}', ProductController::class . ':delete')->setName('product.delete');


$app->get('/categories', CategoryController::class . ':index')->setName('category.list');
$app->get('/categories/{id:[\d]+}', CategoryController::class . ':get')->setName('category.get');
$app->put('/categories/{id:[\d]+}', CategoryController::class . ':update')->setName('category.update');
$app->post('/categories', CategoryController::class . ':insert')->setName('category.insert');
$app->delete('/categories/{id:[\d]+}', CategoryController::class . ':delete')->setName('category.delete');
