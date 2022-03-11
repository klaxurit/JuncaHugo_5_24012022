<?php
ini_set('display_errors', 1);
error_reporting(-1);

define("ROOT_DIR", realPath(dirname(__DIR__)));
define("CONF_DIR", ROOT_DIR. "/config");

require ROOT_DIR. "/vendor/autoload.php";

use App\Controllers\ErrorController;
use App\Core\Router;
use App\Exceptions\ConfigNotFound;
use App\Exceptions\ControllerNotFound;

// Create a new instance of router if controller exist, else, return an error
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
} catch(ConfigNotFound $e) {
    $controller = new ErrorController("showError", [
        "message"=>$e->getMessage()
    ]);
    $controller->execute();
}