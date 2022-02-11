<?php
error_reporting(-1);

define("ROOT_DIR", realPath(dirname(__DIR__)));
define("CONF_DIR", ROOT_DIR. "/config");

require ROOT_DIR. "/vendor/autoload.php";
use App\Core\Router;

try {

    $router = new Router;
    $controller = $router->getController;
    if (is_null($controller)) {
        // throw new ControllerNotFound();
    }
    // Execute method
    $controller->execute();
    
} catch(Error $error) {
    die($error);
}