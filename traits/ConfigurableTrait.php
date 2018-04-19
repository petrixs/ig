<?php

namespace Application\traits;

trait ConfigurableTrait {

    protected $_config;

    public function setConfig($config) {
        $this->_config = $config;
    }

}