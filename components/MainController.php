<?php

namespace Application\components;

use Application\interfaces\ViewControllerInterface;
use Twig_Environment;

class MainController implements ViewControllerInterface {

    /**
     * @var $view Twig_Environment
     */
    protected $view;

    public function initTemplateEngine($templateEngine) {
        $this->view = $templateEngine;
    }

}