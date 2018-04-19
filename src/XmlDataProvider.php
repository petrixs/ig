<?php

namespace IG;

use IG\exceptions\IvalidDataException;
use IG\interfaces\DataProviderInterface;

class XmlDataProvider extends DataProvider implements DataProviderInterface {

    public function getData():array {

        $data = simplexml_load_string($this->data);

        $result = null;

        if(!$data) {
            throw new IvalidDataException('Invalid json data');
        }


        foreach($data as $key => $value) {

        }


        return $result;
    }


}