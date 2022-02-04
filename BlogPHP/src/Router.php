<?php

namespace App;

class Router {

    private $url;
    private $routes = [];

    public function __construct($url) {
        $this->url = $url;
    }

    // Detect all routes with get method
    public function get($path, $callable){
        // Create a new instance of Route
        $route = new Route($path, $callable);
        // Save route in route[] array
        $this->routes['GET'][] = $route;
    }

    // Detect all routes with post method
    public function post($path, $callable){
        // Create a new instance of Route
        $route = new Route($path, $callable);
        // Save route in route[] array
        $this->routes['POST'][] = $route;
    }

    // Check if URL match esle return Excpetion
    public function run(){
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new \Exception('No routes matches');
        }
    }
}