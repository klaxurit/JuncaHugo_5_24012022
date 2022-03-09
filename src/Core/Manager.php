<?php

namespace App\Core;

use PDO;
use App\Core\PDOFactory;

class Manager
{

  protected PDO $pdo;

  public function __construct()
  {
    $this->pdo = (new PDOFactory())->getSQLConnexion();
    // var_dump($this->pdo, "dump de this->pdo dans managerphp");
  }
}
