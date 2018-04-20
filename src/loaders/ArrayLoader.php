<?php

namespace IG\loaders;

class ArrayLoader extends BaseLoader {

    public function load()
    {
        return require $this->path;
    }
}