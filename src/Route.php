<?php

namespace App;

class Route {

    private $path;
    private $callable;

    public function __construc($path, $callable){
        $this->path = $path;
        $this->callable = $callable;
    }
}