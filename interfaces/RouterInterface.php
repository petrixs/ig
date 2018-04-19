<?php

namespace Application\interfaces;

use Application\traits\RepositoryTrait;

interface RouterInterface {

    public function setRequest(RequestInterface $request);

    public function dispatch();
}