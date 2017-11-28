<?php

namespace App\Core;

use Kitchenu\Debugbar\SlimDebugBar;
use OlajosCs\QueryBuilder\Contracts\Connection;


/**
 * Class Container
 * An extension of the Slim Container to have typehinting for properties
 *
 * @property array                  settings
 *
 * @property Config                 $config
 * @property Connection             $db
 * @property SlimDebugBar           $debugbar
 */
class Container extends \Slim\Container
{
}
