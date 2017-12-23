<?php

namespace App\Core;

use Interop\Container\ContainerInterface;
use InvalidArgumentException;

/**
 * Class App
 *
 * An extension for the Slim App to have Container property typehints
 */
class App extends \Slim\App
{
    /**
     * Create new application
     *
     * @param ContainerInterface|array $container Either a ContainerInterface or an associative array of app settings
     *
     * @throws InvalidArgumentException when no container is provided that implements ContainerInterface
     */
    public function __construct($container)
    {
        if (is_array($container)) {
            $container = new Container($container);
        }
        if (!$container instanceof ContainerInterface) {
            throw new InvalidArgumentException('Expected a ContainerInterface');
        }

        parent::__construct($container);
    }


    /**
     * @inheritdoc
     *
     * @return Container
     */
    public function getContainer(): Container
    {
        return parent::getContainer();
    }
}
