<?php

namespace App\Core;

use PDO;
use App\Core\PDOFactory;
use App\Session\PHPSession;

class Manager
{

  protected PDO $pdo;
  protected $session;

  public function __construct()
  {
    $this->pdo = (new PDOFactory())->getSQLConnexion();
    $this->session = new PHPSession;
  }
}
