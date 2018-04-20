<?php

namespace IG\loaders;

use IG\interfaces\LoaderInterface;

abstract class BaseLoader implements LoaderInterface {

    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

}