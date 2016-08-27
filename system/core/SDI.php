<?php

/**
 * Simple Dependency Injuctor
 */



class SDI
{
    private $services = [];    

    public function listServices()
    {
        return array_keys($this->services);
    }

    public function register($service_name, callable $callables)
    {
        $this->services[$service_name] = $callables;
    }

    public function getService($service_name,$arg = [])
    {
        if (!array_key_exists($service_name, $this->services)) {
            throw new \Exception("Service '$service_name' Not Registered ");
        }
        if (!empty($arg)) {
        	return $this->services[$service_name]($arg);
        }
        return $this->services[$service_name]();
    }
    public function __set($service_name, callable $callables)
    {
        $this->register($service_name, $callables);
    }
    public function __get($service_name)
    {
        return $this->getService($service_name);
    }
}
