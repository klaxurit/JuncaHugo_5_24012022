<?php

namespace App\Core;


Class Router {

    private $controller;

    public function __construct() {
        $this->controller = $this->setController();
    }

    public function getController() {
        return $this->controller;
    }

    //retirer le p05/public... de l'url voir les function str
    //comparer les url routes.yml et $uri avec preg_match  
    public function setController() {
        $routesFile = CONF_DIR. "/routes.yml";
        $routes = yaml_parse_file($routesFile);
        // var_dump($routes, "ROUTES");
        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        var_dump($uri, "URI 1");
        foreach($routes as $route) {
            // $uri = trim($uri, '/');

            // $regex = "#^$uri$#i";
            // var_dump($regex, "REGEX");
            $trimmedUri = trim($uri, "/P05_junca_hugo/public");
            // var_dump($trimmedUri, "TRIMMED URI");
            // var_dump($uri, "URI");
            foreach ($routes as $route) {
                if(!preg_match($trimmedUri, $route["uri"], $matches)){
                    var_dump($matches, "MATCHES");
                    return false;
                }
                $blabla = array_combine($matches, $routes);
                var_dump($blabla, "ARRAY_COMBINE");
                return true;
                var_dump($matches, "MATCHES");
            }
            
            $blabla = array_combine($matches, $routes);
            var_dump($blabla, "ARRAY_COMBINE");
            return true;
            var_dump($matches, "MATCHES");
            // var_dump($uri);
            // die();
            // Trimer l'uri - venir comparer la route uri avec un preg_match - si ça match créer le chemin du controller
            // faire un array_combine pour créer un tableau de paramètre
            // this->controller = New $ControllerName($route[action], $params)
            // return $this->controller
        }
    }
}