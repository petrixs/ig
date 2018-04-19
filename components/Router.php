<?php

namespace Application\components;

use Application\exceptions\InitializationException;
use Application\exceptions\NotFoundException;
use Application\interfaces\ConfigurableInterface;
use Application\interfaces\RequestInterface;
use Application\interfaces\RouterInterface;
use Application\traits\ConfigurableTrait;

class Router implements RouterInterface, ConfigurableInterface {

    use ConfigurableTrait;

    protected $request;

    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * Dispatch route and init controller
     * @throws NotFoundException
     */
    public function dispatch()
    {
        if(!$this->request)
            throw new InitializationException('Request is empty');

        $path = $this->request->server['REQUEST_METHOD'].' '.$this->request->server['REQUEST_URI'];


        if(isset($this->_config['routes'][$path])) {

            $route_path = explode('/', $this->_config['routes'][$path]);

            $controller = ucfirst($route_path[0]).'Controller';
            $method = $route_path[1];

            $controllerFullPath = $this->_config['controllerNamespace'].'\\'.$controller;


            if(class_exists($controllerFullPath)){

                $controllerInstance = new $controllerFullPath;

                if(is_callable([$controllerInstance, $method])) {
                    $controllerInstance->$method();
                } else {
                    throw new InitializationException('Controller '.$controller.' method '.$method.' not found');
                }

            } else {
                throw new InitializationException('Controller '.$controller.' not found');
            }

        } else {
            throw new NotFoundException('Page not found');
        }


    }

}