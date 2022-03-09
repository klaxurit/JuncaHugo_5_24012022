<?php

namespace App\Core;

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
    $dir = CONF_DIR . "/db-config.yml";
    $config = yaml_parse_file($dir);
    return $config;
  }

  public function getSQLConnexion()
  {
    // $db = new \PDO("mysql:host=localhost;dbname=blog", 'root', '1234');
    // var_dump($this->config['db_host'], $this->config['db_name'], $this->config['db_user'], $this->config['db_password'], 'dump de db_user et db_password');
    $db = new \PDO('mysql:host=' . $this->config['db_host'] . ';dbname=' . $this->config['db_name'], $this->config['db_user'], $this->config['db_password']);
    // var_dump($db,'dump de $db');
    // var_dump(phpinfo());
    $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    // var_dump($db,'dump de $db après setAttribute');
    return $db;
  }
}
