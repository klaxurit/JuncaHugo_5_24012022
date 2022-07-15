<?php

namespace App\Core;

use App\Core\Controller;
use App\Managers\AdminManager;
use App\Controllers\AdminController;
use App\Controllers\ErrorController;

class Router
{

    private $controller;

    public function __construct()
    {
        $this->controller = $this->setController();
    }

    public function getController()
    {
        return $this->controller;
    }

    public function setController()
    {
        @session_start();
        $routesFile = CONF_DIR . "/routes.yml";
        // Read and parse route config file
        $routes = yaml_parse_file($routesFile);
        // array(2) { ["path"]=> string(5) "/tutu" ["query"]=> string(10) "artcile=12" } string(5) "/tutu"
        // Get and parse url params and path
        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        if (isset($_SESSION['user'])) {
            $user = $_SESSION["user"];
        }
        // var_dump($uri);
        foreach ($routes as $route) {
            // Search in route config file if we have match between requested URI and Routes in routes.yml
            if (preg_match("#^" . $route["uri"] . "$#", $uri, $matches)) {
                // Build controller path
                $controller = "\\App\\Controllers\\" . $route["controller"];
                // Search and assign parameters of URI
                $params = array_combine($route["parameters"], array_slice($matches, 1));
                // Check if uri contain /admin and if current user is admin
                $admin = (new AdminManager())->findAdmin();
                if (strpos($uri, "/admin") === 0 && isset($_SESSION["user"]) && $user["id"] !== $admin->getUserId()){
                    return $controller = new ErrorController("show403");
                }
                // Return a new instance of Controller with params
                return new $controller($route["action"], $params);
            }
        }
    }
}
