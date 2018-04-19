<?php

namespace IG;

use IG\exceptions\IvalidDataException;
use IG\interfaces\DataProviderInterface;

class JsonDataProvider extends DataProvider implements DataProviderInterface {

    public function getData():array {

        $data = json_decode($this->data, true);

        if(!$data) {
            throw new IvalidDataException('Invalid json data');
        }

        return $data;
    }


}