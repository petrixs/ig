<?php

namespace Application\components;

use Application\exceptions\InitializationException;
use Application\exceptions\NotFoundException;
use Application\interfaces\ConfigurableInterface;
use Application\interfaces\RequestInterface;
use Application\interfaces\RouterInterface;
use Application\interfaces\ViewControllerInterface;
use Application\traits\ConfigurableTrait;

class Router implements RouterInterface, ConfigurableInterface {

    use ConfigurableTrait;

    protected $request;

    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @todp: too many logic, decomposite on methods
     * Dispatch route and init controller
     * @throws NotFoundException
     */
    public function dispatch(): void
    {
        if(!$this->request)
            throw new InitializationException('Request is empty');

        $request_uri_parts = explode('?', $this->request->server['REQUEST_URI']);

        $path = $this->request->server['REQUEST_METHOD'].' '.$request_uri_parts[0];

        if(isset($this->_config['routes'][$path])) {

            $route_path = explode('/', $this->_config['routes'][$path]);

            $controller = ucfirst($route_path[0]).'Controller';
            $method = $route_path[1];

            $controllerFullPath = $this->_config['controllerNamespace'].'\\'.$controller;


            if(class_exists($controllerFullPath)){

                $controllerInstance = new $controllerFullPath;

                if($controllerInstance instanceof ViewControllerInterface)
                {
                    /**
                     * @var object $templateEngine
                     */
                    $templateEngine = new $this->_config['view']['class'];

                    $controllerInstance->initTemplateEngine(
                        $templateEngine::init(
                            $this->_config['view']
                        )
                    );
                }

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