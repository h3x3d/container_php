<?php

namespace Container;

class Container
{
    private $services = [];
    private $instances = [];

    public function set($name, $factory)
    {
        $services[$name] = $factory;

        return $factory;
    }

    public function get($name, $args = [])
    {
        if (!$services[$name]) {
            throw new Exception("Undefined service '$name'");
        }

        if (empty($args)) {
            if (!isset($instances[$name])) {
                $instances[$name] = $services[$name]($this);
            }

            return $instances[$name];
        }

        array_unshift($args, $this);

        return call_user_func_array($instances[$name], $args);
    }

    public function factory($name)
    {
        return $services[$name];
    }
}
