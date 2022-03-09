<?php

namespace App\Managers;

use PDO;
use App\Core\Manager;

class AdminManager extends Manager
{
  public function __construct(){
    parent::__construct();
  }

  public function findAdmin()
  {
    $sql = "SELECT * FROM admin";
    $req = $this->pdo->prepare($sql);
    $req->execute();
    $datas = $req->fetchAll(PDO::FETCH_COLUMN, 2);
    return $datas;
  }
}