<?php

namespace Application\controllers;

use Application\components\MainController;
use IG\Agregator;
use IG\exceptions\InvalidDataException;
use IG\loaders\ArrayLoader;
use IG\loaders\FileLoader;
use IG\ProviderFactory;

class StorageController extends MainController {

    public function index() {

        $result = 'empty result';

        // @todo: move superglobals to application request object
        if(isset($_GET['type'])) {

            try {

                /**
                 * Data loader
                 */
                if($_GET['type'] == ProviderFactory::TYPE_ARRAY) {
                    $loader = new ArrayLoader('../data/data.php');
                } else {
                    $loader = new FileLoader('../data/data.'.$_GET['type']);
                }

                /**
                 * Factory for data type
                 */
                $provider = ProviderFactory::factory($_GET['type'], $loader);

                /**
                 * Insert provider to aggregator
                 */
                $aggregator = new Agregator($provider, $_GET);
                $result = $aggregator->execute();

                // !!! It's example, on production code result is Framework Response object(Facade)
                $result = json_encode($result, JSON_PRETTY_PRINT);

            } catch(InvalidDataException $e) {
                $result = 'Error: '.$e->getMessage();
            }

        }

        $this->view->display('index.html', [
            'result' => $result
        ]);

    }

}