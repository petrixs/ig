<?php

namespace Application\components;

use Application\exceptions\InitializationException;
use Application\interfaces\ConfigurableInterface;
use Application\interfaces\RequestInterface;
use Application\interfaces\RouterInterface;

/**
 * Class Application - main application class
 * @package Application\components
 */

class Application {

    protected $config;

    /**
     * @param
     */
    protected $router;

    /**
     * @param
     */
    protected $request;

    /**
     * Application constructor.
     * @param array $config
     * @throws InitializationException
     */
    public function __construct(array $config)
    {
        $this->config  = $config;

        // @todo: Create and move to ApplicationRepository and inject to controller via DI
        $this->router  = $this->initComponent('router');
        $this->request = $this->initComponent('request');
    }

    /**
     * Run application
     */
    public function run():void {
        $this->processRequest($this->request, $this->router);
    }

    /**
     * Process incoming request
     * @param RequestInterface $request
     * @param RouterInterface $router
     */
    protected function processRequest($request, RouterInterface $router) {
        $router->setRequest($request);
        $router->dispatch();
    }

    /**
     * @param $component string config component name
     * @return object config component instance
     * @throws InitializationException
     */
    protected function initComponent($component) {

        if(!isset($this->config[$component]) || !isset($this->config[$component]['class']))
            throw new InitializationException($component . ' component doesn\'t exist in file configuration');

        if(!class_exists($this->config[$component]['class']))
            throw new InitializationException($component . ' class doesn\'t exist');

        $instance = new $this->config[$component]['class'];

        /**
         * Check for config support
         */
        if($instance instanceof ConfigurableInterface) {
            $instance->setConfig($this->config[$component]);
        }

        return new $router($this->config[$component]);
    }

}