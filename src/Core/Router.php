<?php

namespace App\Core;


Class Router {

    private $controller;

    public function __construct() {
        $this->controller = $this->setController;
    }

    public function getController() {
        return $$this->controller;
    }

    public function setController() {
        $routesFile = CONF_DIR. "/routes.yml";
        $routes = yaml_parse_file($routesFile);
        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        foreach($routes as $route) {
            // Trimer l'uri - venir comparer la route uri avec un preg_match - si ça match créer le chemin du controller
            // faire un array_combine pour créer un tableau de paramètre
            // this->controller = New $ControllerName($route[action], $params)
            // return $this->controller
        }
    }
}