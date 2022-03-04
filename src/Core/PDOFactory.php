<?php

namespace App\Core;

use PDO;

class PDOFactory
{

  private array $config;

  function __construct()
  {
    $this->config = $this->getConfig();
  }

  private function getConfig()
  {
    $dir = CONF_DIR . "/db-config.yml";
    $config = yaml_parse_file($dir);
    return $config;
  }

  public function getSQLConnexion()
  {
    $db = new PDO("mysql:host=" . $this->config['db_host'] . ";dbname=" . $this->config['db_name'], $this->config['db_user'], $this->config['db_password']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }
}
