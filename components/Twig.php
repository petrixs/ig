<?php

namespace Application\components;

use Application\interfaces\InitConfigInterface;
use Twig_Environment;
use Twig_Loader_Filesystem;

class Twig implements InitConfigInterface {

    public static function init(array $config) {

        $loader = new Twig_Loader_Filesystem(
            $config['templateDir']
        );

        return new Twig_Environment($loader, $config['params']);
    }

}