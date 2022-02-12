<?php

namespace App\Core;

use App\Core\Controller;

Class Router {

    private $controller;

    public function __construct() {
        $this->controller = $this->setController();
    }

    public function getController() {
        return $this->controller;
    }

    public function setController() {
        $routesFile = CONF_DIR. "/routes.yml";
        $routes = yaml_parse_file($routesFile);
        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        // var_dump($uri, "URI 1");

            foreach ($routes as $route) {
                // var_dump($uri, $route["uri"]);
                if(preg_match("#^". $route["uri"] . "$#", $uri, $matches)){
                    // var_dump($route["controller"]);
                    $controller = "\\App\\Controllers\\" . $route["controller"];
                    $params = array_combine($route["parameters"], array_slice($matches, 1));
                    return new $controller($route["action"], $params);
                }
            }
    }
}