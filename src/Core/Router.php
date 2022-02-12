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
        var_dump($uri, "URI 1");
        foreach($routes as $route) {
            foreach ($routes as $route) {
                var_dump($uri, $route["uri"]);
                if($uri == $route["uri"]){
                    $controller = "\\App\\Controllers\\" . $route["controller"];
                    return new $controller($route["action"], $route["parameters"]);
                }
            }
            
            // var_dump($uri);
            // die();
            // Trimer l'uri - venir comparer la route uri avec un preg_match - si ça match créer le chemin du controller
            // faire un array_combine pour créer un tableau de paramètre
            // this->controller = New $ControllerName($route[action], $params)
            // return $this->controller
        }
    }
}