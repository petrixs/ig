<?php

namespace IG\loaders;


class FileLoader extends BaseLoader {

    public function load()
    {
        return file_get_contents($this->path);
    }
}