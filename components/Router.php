<?php

namespace Application\components;

use Application\interfaces\InitializationException;
use Application\interfaces\RequestInterface;

class Router implements RouterInterface {

    protected $request;

    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function dispatch(): array
    {
        if(!$this->request)
            throw new InitializationException('Request is empty');

    }

}