<?php

namespace IG;

abstract class DataProvider {

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

}