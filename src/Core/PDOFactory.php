<?php

namespace App\Core;

use App\Exceptions\ConfigNotFound;

class PDOFactory
{

  private array $config;

  public function __construct()
  {
    $this->config = $this->getConfig();
  }

  /**
   * get db config file if exist, if not throw new ConfigNotFound exception
   *
   * @return void
   */
  private function getConfig()
  {
    $dir = CONF_DIR . "/db-config.yml";
    if (!file_exists($dir)) {
      throw new ConfigNotFound("No database config found");
    }
    $config = yaml_parse_file($dir);
    return $config;
  }

  /**
   * create new instance of PDO with data from db-config file
   *
   * @return void
   */
  public function getSQLConnexion()
  {
    $database = new \PDO('mysql:host=' . $this->config['db_host'] . ';dbname=' . $this->config['db_name'], $this->config['db_user'], $this->config['db_password']);
    $database->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    return $database;
  }
}
