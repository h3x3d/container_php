<?php

namespace H3x3d;

class Container
{
    private static $instance = null;

    private $services = [];
    private $instances = [];

    public function set($name, $factory)
    {
        $this->services[$name] = $factory;

        return $factory;
    }

    public function get($name)
    {
        $args = func_get_args();
        array_shift($args);

        if (!$this->services[$name]) {
            throw new Exception("Undefined service '$name'");
        }

        if (empty($args)) {
            if (!isset($this->instances[$name])) {
                $this->instances[$name] = $this->services[$name]($this);
            }

            return $this->instances[$name];
        }

        array_unshift($args, $this);

        return call_user_func_array($this->services[$name], $args);
    }

    public function factory($name)
    {
        return function () use ($name) {
            $args = func_get_args();
            array_unshift($args, $this);

            return call_user_func_array($this->services[$name], $args);
        };
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
