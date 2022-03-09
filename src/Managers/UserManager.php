<?php

namespace App\Managers;

use PDO;
use App\Core\Manager;

class UserManager extends Manager
{
  public function __construct(){
    parent::__construct();
  }

  public function findUsers()
  {
    $sql = "SELECT * FROM user";
    $req = $this->pdo->prepare($sql);
    $req->execute();
    $datas = $req->fetchAll(PDO::FETCH_COLUMN, 2);
    return $datas;
  }
}
