<?php

namespace Application\components;

use Application\interfaces\RequestInterface;

interface RouterInterface {

    public function setRequest(RequestInterface $request);

    public function dispatch(): array;
}