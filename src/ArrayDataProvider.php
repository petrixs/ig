<?php

namespace IG;

use IG\exceptions\InvalidDataException;
use IG\interfaces\DataProviderInterface;

class ArrayDataProvider extends DataProvider implements DataProviderInterface {

    public function __construct()
    {
        $this->data = require 'data/data.php';
    }

    public function getData():array {

        if(!$this->data) {
            throw new InvalidDataException('Invalid data');
        }


        foreach($this->data as $key => $value) {

            $array = [];

            foreach($value as $k => $v) {
                $this->data[$key][$k]['code'] = $k;
                $this->data[$key][$k]['price'] = $v['value'];
                unset($this->data[$key][$k]['value']);
                $array[] = $this->data[$key][$k];

            }

            $this->data[$key] = $array;

        }

        return $this->data;
    }

}