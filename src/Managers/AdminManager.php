<?php

namespace App\Managers;

use PDO;
use App\Core\Manager;
use App\Model\Admin;
use App\Model\User;

class AdminManager extends Manager
{
  public function __construct()
  {
    parent::__construct();
  }

    
  /**
   * Find admin
   *
   * @return void
   */
  public function findAdmin()
  {
    $sql = "SELECT * FROM admin";
    $req = $this->pdo->prepare($sql);
    $req->execute();
    $datas = $req->fetch();
    $admin = new Admin($datas);


    $sql = "SELECT * FROM user WHERE id=" . $admin->getUserId();
    $req = $this->pdo->prepare($sql);
    $req->execute();
    $dataUser = $req->fetch();
    $user = new User($dataUser);
    $admin->setUser($user);

    return $admin;
  }
}
