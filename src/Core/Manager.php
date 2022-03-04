<?php 

namespace App\Core;

use PDO;

class Manager {

  protected PDO $pdo;

  public function __construct() {
    $this->pdo = (new PDOFactory())->getSQLConnexion();
  }
}