<?php
/**
 *
 */
class Service
{
    private $services = [];

    public function __construct()
    {
        $di       = $GLOBALS['DI'];
        $services = $di->listServices();
        foreach ($services as $service) {
            $this->$service = $di->$service;
        }
    }

    public function register($service_name, $callables)
    {
        $this->services[$service_name] = $callables;
    }

    public function getService($service_name, $arg = [])
    {
        if (!array_key_exists($service_name, $this->services)) {
            throw new \Exception("Service '$service_name' Not Registered ");
        }
        if (!empty($arg)) {
            return $this->services[$service_name]($arg);
        }
        return $this->services[$service_name];
    }

    public function __set($service_name, $callables)
    {
        $this->register($service_name, $callables);
    }

    public function __get($service_name)
    {
        return $this->getService($service_name);
    }

}
