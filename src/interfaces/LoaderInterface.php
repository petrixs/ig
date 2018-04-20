<?php

namespace IG\interfaces;

interface LoaderInterface {

    public function __construct($path);

    public function load();

}