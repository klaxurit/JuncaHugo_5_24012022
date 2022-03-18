<?php

namespace App\Managers;

use PDO;
use App\Core\Manager;
use App\Model\Admin;

class AdminManager extends Manager
{
  public function __construct()
  {
    parent::__construct();
  }

  public function findAdmin()
  {
    $sql = "SELECT * FROM admin";
    $req = $this->pdo->prepare($sql);
    $req->execute();
    $datas = $req->fetchAll();
    $admin = new Admin($datas);
    return $admin;
  }
}
