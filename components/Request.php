<?php

namespace Application\components;

use Application\interfaces\RequestInterface;
use Application\traits\RepositoryTrait;

class Request implements RequestInterface {

    use RepositoryTrait;

    public function __construct()
    {
        $this->query = $_GET;
        $this->server = $_SERVER;
        $this->post = $_POST;
    }

}