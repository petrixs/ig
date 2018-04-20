<?php

namespace IG;

use IG\interfaces\DataProviderInterface;

class Agregator {

    const EXPRESSION_TYPE_LIKE = 'like';
    const EXPRESSION_TYPE_GT = '>';
    const EXPRESSION_TYPE_LT = '<';

    const SORT_TYPE_ASC  = 'asc';
    const SORT_TYPE_DESC = 'desc';

    protected $data;
    protected $request;

    public function __construct(DataProviderInterface $provider, $request)
    {
        $this->data    = $provider->getData();
        $this->request = $request;
    }

    public function applySort(string $param, string $type) {
        foreach($this->data as $groupName => $inventory) {
            $sorted = array();

            foreach ($inventory as $key => $row)
            {
                $sorted[$key] = $row[$param];
            }

            if($type == self::SORT_TYPE_DESC)
                array_multisort($sorted, SORT_DESC, $inventory);

            if($type == self::SORT_TYPE_ASC)
                array_multisort($sorted, SORT_ASC, $inventory);

            $this->data[$groupName] = $inventory;
        }
    }

    public function applyFilter(string $field, string $expression, $value) {
        foreach($this->data as $groupName => $v) {
            foreach($v as $index => $groupItemData) {

                if(isset($groupItemData[$field]) &&
                    !$this->compareAttributes($groupItemData[$field], $expression, $value))
                {
                    unset($this->data[$groupName][$index]);
                }

            }
        }
    }

    public function compareAttributes($fieldValue, $expression, $value):bool {

        $result = true;

        if($expression == self::EXPRESSION_TYPE_LIKE && strripos($fieldValue, $value) === false)
            return false;

        if($expression == self::EXPRESSION_TYPE_GT && $fieldValue <= $value)
            return false;

        if($expression == self::EXPRESSION_TYPE_LT && $fieldValue >= $value)
            return false;

        return $result;
    }

    public function applyGroup($groupName) {
        foreach($this->data as $k => $v) {
            if($k != $groupName) {
                unset($this->data[$k]);
            }
        }
    }

    public function execute(): array {

        if($this->request) {
            //group
            if(isset($this->request['group']) && !empty($this->request['group'])) {
                $this->applyGroup($this->request['group']);
            }

            //filter
            if( isset($this->request['filter']) &&
                !empty($this->request['filter']) &&

                isset($this->request['filter_type']) &&
                !empty($this->request['filter_type']) &&

                isset($this->request['filter_value']) &&
                !empty($this->request['filter_value'])

            ) {
                $this->applyFilter($this->request['filter'], $this->request['filter_type'], $this->request['filter_value']);
            }

            //sort
            if( isset($this->request['sort']) &&
                !empty($this->request['sort']) &&

                isset($this->request['sort_type']) &&
                !empty($this->request['sort_type'])
            ) {
                $this->applySort($this->request['sort'], $this->request['sort_type']);
            }

        }

        return $this->data;

    }

}