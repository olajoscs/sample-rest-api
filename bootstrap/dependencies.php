<?php

/** @var App\Core\App $app */

use App\Controllers\CategoryController;
use App\Controllers\ProductController;
use App\Core\Config;
use App\Repositories\CategoryRepository;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\ProductRepositoryInterface;
use App\Services\ProductProvider;
use App\Services\ProductProviderInterface;
use App\Services\Response\CategoryBuilder;
use App\Services\Response\ProductBuilder;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Response;

$container = $app->getContainer();

$container[Config::class] = function(Container $container) {
    /** @var \Slim\Collection $configArray */
    $configArray = $container->settings;
    return new Config($configArray->all());
};

$container['db'] = function(Container $container) {
    $configArray = $container->get(Config::class)->get('database');

    /*
     * TODO: Have a default class in the QueryBuilder library
     */
    $config = new class($configArray) implements \OlajosCs\QueryBuilder\Config {
        private $config;
        public function __construct(array $config)
        {
            $this->config = $config;
        }

        public function getHost()
        {
            return $this->config['host'];
        }

        public function getUser()
        {
            return $this->config['username'];
        }

        public function getPassword()
        {
            return $this->config['password'];
        }

        public function getDatabase()
        {
            return $this->config['database'];
        }

        public function getOptions()
        {
            return $this->config['options'];
        }

        public function getDatabaseType()
        {
            return $this->config['type'];
        }

    };

    $pdo = new \OlajosCs\QueryBuilder\PDO($config);
    $connectionFactory = new \OlajosCs\QueryBuilder\ConnectionFactory();

    return $connectionFactory->create($pdo);
};


/*
 * Error handlers
 * TODO: JSON response body-kat tömb helyett szabványosítani objektumban
 * TODO: function function-öket objektumokba kipakolni
 */
$container['notFoundHandler'] = function (Container $container) {
    return function (ServerRequestInterface $request, Response $response) {
        return $response
            ->withStatus(404)
            ->withHeader('Content-Type', 'Application/json')
            ->write(json_encode([
                'status' => 'error',
                'message' => 'Page not found'
            ]));
    };
};

$container['notAllowedHandler'] = function (Container $container) {
    return function (ServerRequestInterface $request, Response $response, array $methods) {
        return $response
            ->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader('Content-type', 'Application/json')
            ->write(json_encode([
                    'status' => 'error',
                    'message' => 'Method must be one of: ' . implode(', ', $methods)]
            ));
    };
};


/*
 * Product dependencies
 */

$container[ProductRepositoryInterface::class] = function($container) {
    return new ProductRepository($container->db);
};

$container[CategoryRepositoryInterface::class] = function ($container) {
    return new CategoryRepository($container->db);
};

$container[CategoryBuilder::class] = function ($container) {
    return new CategoryBuilder();
};

$container[ProductBuilder::class] = function ($container) {
    return new ProductBuilder(
        $container[CategoryRepositoryInterface::class],
        $container[CategoryBuilder::class]
    );
};

$container[ProductProviderInterface::class] = function ($container) {
    return new ProductProvider(
        $container[ProductRepositoryInterface::class],
        $container[ProductBuilder::class]
    );
};

$container[ProductController::class] = function ($container) {
    return new ProductController(
        $container[ProductProviderInterface::class],
        $container[ProductRepositoryInterface::class],
        new \Particle\Validator\Validator(),
        $container[CategoryRepositoryInterface::class]
    );
};


$container[CategoryController::class] = function (Container $container) {
    return new CategoryController(
        $container->get(CategoryRepositoryInterface::class),
        new \Particle\Validator\Validator()
    );
};
