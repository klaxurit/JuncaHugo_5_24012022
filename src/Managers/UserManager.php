<?php

namespace App\Managers;

use PDO;
use App\Model\User;
use App\Core\Manager;

class UserManager extends Manager
{
  public function __construct()
  {
    parent::__construct();
  }


  /**
   * find all users in db
   *
   * @return void
   */
  public function findUsers()
  {
    $sql = "SELECT * FROM user";
    $req = $this->pdo->prepare($sql);
    $req->execute();
    $datas = $req->fetchAll(PDO::FETCH_COLUMN, 2);
    return $datas;
  }

  public function createUser()
  {
    $sql = "INSERT INTO `user`(`nom`, `prenom`, `surnom`, `email`, `password`) VALUES (:nom, :prenom, :surnom, :email, '$password')";
    $req = $this->pdo->prepare($sql);
    $req->execute();
    $datas = $req->fetch();
    return new User($datas);
  }
}
