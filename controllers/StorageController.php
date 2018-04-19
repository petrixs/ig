<?php

namespace Application\controllers;

use Application\components\MainController;

class StorageController extends MainController {

    public function index() {

        $result = 'test';


        $this->view->display('index.html', [
            'result' => $result
        ]);

    }

}