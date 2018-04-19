<?php

namespace IG\interfaces;


interface DataProviderInterface
{
    public function __construct($data);

    public function getData();
}