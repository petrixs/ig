<?php

namespace IG;

use IG\exceptions\InvalidDataException;
use IG\interfaces\DataProviderInterface;

class XmlDataProvider extends DataProvider implements DataProviderInterface {

    public function __construct()
    {
        $this->data = file_get_contents('data/data.xml');
    }

    public function getData():array {

        $data = simplexml_load_string($this->data);

        $result = null;

        if(!$data) {
            throw new InvalidDataException('Invalid xml data');
        }

        foreach($data as $k => $node) {

            $result[(string)$node->attributes()['Type']][] = [
                'code'  => (string)$node->Code,
                'price' => (string)$node->Value,
                'name'  => (string)$node->Description
            ];
        }

        return $result;
    }


}