<?php

namespace App\Core;

use App\Exceptions\ConfigNotFound;
use App\Controllers\ErrorController;

// use PDO;

class PDOFactory
{

  private array $config;

  function __construct()
  {
    $this->config = $this->getConfig();
  }

  private function getConfig()
  {
    try {
      $dir = CONF_DIR . "/db-config.yml";
      if (!file_exists($dir)) {
        throw new ConfigNotFound();
      }
      $config = yaml_parse_file($dir);
      return $config;
    } catch (ConfigNotFound $e) {
      $controller = new ErrorController("showError", [
        "message"->$e
      ]);
      $controller->execute();
    }
  }

  public function getSQLConnexion()
  {
    $db = new \PDO('mysql:host=' . $this->config['db_host'] . ';dbname=' . $this->config['db_name'], $this->config['db_user'], $this->config['db_password']);
    $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    var_dump($db);
    return $db;
  }
}
