<?php

/** @var App\Core\App $app */

use App\Controllers\ProductController;
use App\Core\Container;
use App\Repositories\CategoryRepository;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\ProductRepositoryInterface;
use App\Services\ProductProvider;
use App\Services\ProductProviderInterface;
use App\Services\Response\CategoryBuilder;
use App\Services\Response\ProductBuilder;

$container = $app->getContainer();

/**
 * Config beállítása
 *
 * @param Container $container
 *
 * @return \App\Core\Config
 */
$container['config'] = function($container) {
    $configArray = include __DIR__ . '/../config/config.php';

    $config = new \App\Core\Config($configArray);

    $settings                        = $container->settings;
    $settings['displayErrorDetails'] = $config->get('error.display');

    $container->settings = $settings;

    return $config;
};


/**
 * DB kapcsolat beállítása
 *
 * @param Container $container
 *
 * @return \OlajosCs\QueryBuilder\Contracts\Connection
 * @throws Exception
 */
$container['db'] = function($container) {
    $configArray = $container->config->get('database');

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
