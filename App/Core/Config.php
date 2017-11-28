<?php

namespace App\Core;

/**
 * Class Config
 *
 * Basic configuration reader
 */
class Config
{
    /**
     * @var array
     */
    private $config;


    /**
     * Create a new Config object
     *
     * @param array $configArray
     */
    public function __construct(array $configArray)
    {
        $this->config = $configArray;
    }


    /**
     * Return that a config key exists or not
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key): bool
    {
        return array_get($this->config, $key) === null;
    }


    /**
     * Return a config value
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $value = array_get($this->config, $key);

        if ($value === null) {
            return $default;
        }

        return $value;
    }


    /**
     * Set a config value
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    public function set($key, $value): void
    {
        array_set($this->config, $key, $value);
    }
}
