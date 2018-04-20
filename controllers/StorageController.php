<?php

namespace Application\controllers;

use Application\components\MainController;
use IG\Agregator;
use IG\exceptions\InvalidDataException;
use IG\ProviderFactory;

class StorageController extends MainController {

    public function index() {

        $result = 'empty result';

        // @todo: move superglobals to application request object
        if(isset($_GET['type'])) {

            try {

                if($_GET['type'] == ProviderFactory::TYPE_ARRAY) {
                    $dataType = 'php';
                } else {
                    $dataType = $_GET['type'];
                }

                /**
                 * Factory for data type
                 */
                $provider = ProviderFactory::factory($_GET['type']);

                /**
                 * Insert provider to aggregator
                 */
                $aggregator = new Agregator($provider, $_GET);
                $result = $aggregator->execute();

            } catch(InvalidDataException $e) {
                $result = 'Error: '.$e->getMessage();
            }

        }

        $this->view->display('index.html', [
            'result' => $result
        ]);

    }

}