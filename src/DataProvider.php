<?php

namespace IG;

use IG\interfaces\LoaderInterface;

abstract class DataProvider {

    protected $data;

    public function __construct(LoaderInterface $loader)
    {
        $this->data = $loader->load();
    }

}