<?php

namespace IG;

use IG\exceptions\InvalidDataException;
use IG\interfaces\DataProviderInterface;

class JsonDataProvider extends DataProvider implements DataProviderInterface {

    public function getData():array {

        $result = [];

        $data = json_decode($this->data, true);

        if(!$data) {
            throw new InvalidDataException('Invalid json data');
        }

        foreach($data as $key => $value) {
            $result[$value[3]][] = [
                'code'  => $value[0],
                'price' => $value[2],
                'name'  => $value[1]
            ];
        }

        return $result;
    }


}