<?php

namespace Application\components;

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

    public function dispatch(): array
    {
        if(!$this->request)
            throw new InitializationException('Request is empty');

        var_dump($this->request->server);exit();

    }

}