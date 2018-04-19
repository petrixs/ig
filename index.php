<?php

use Application\components\Application;

require_once __DIR__ .'vendor/autoload.php';

$config = require __DIR__ . 'config/app.php';

try {
    $application = new Application($config);
    $application->run();
} catch(\Exception $e) {
    // something here
    echo 'Error: '.$e->getMessage();
}