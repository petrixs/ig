<?php

namespace Application\components;

use Application\exceptions\NotFoundException;
use Application\interfaces\ConfigurableInterface;
use Application\interfaces\InitializationException;
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

            $controller = $route_path[0];
            $method = $route_path[1];

            if(class_exists($this->_config['controllerNamespace'].ucfirst($controller).'Controller')){
                $controller = new $this->_config['controllerNamespace'].ucfirst($controller).'Controller';
            } else {
                throw new InitializationException('Controller not found');
            }

        } else {
            throw new NotFoundException('Page not found');
        }


    }

}