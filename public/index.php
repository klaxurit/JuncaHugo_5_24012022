<?php
error_reporting(-1);

define("ROOT_DIR", realPath(dirname(__DIR__)));
define("CONF_DIR", ROOT_DIR. "/config");

require ROOT_DIR. "/vendor/autoload.php";

use App\Controllers\ErrorController;
use App\Core\Router;
use App\Exceptions\ControllerNotFound;

try {
    $router = new Router;
    $controller = $router->getController();
    if (is_null($controller)) {
        throw new ControllerNotFound();
    }
    $controller->execute();
} catch(ControllerNotFound $e) {
    $controller = new ErrorController("show404");
    $controller->execute();
}