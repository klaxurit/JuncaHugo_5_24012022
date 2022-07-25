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

  public function updateAdminInfos(int $id, int $userId)
  {
    $sql = "UPDATE admin SET `description`=:adminDesc, `tagline`=:tagline WHERE id=:id";

    $req = $this->pdo->prepare($sql);
    $req->bindParam(':adminDesc', $_POST["adminDesc"], PDO::PARAM_STR);
    $req->bindParam(':tagline', $_POST["tagline"], PDO::PARAM_STR);
    $req->bindParam('id', $id, PDO::PARAM_STR);
    $req->execute();

    $sql = "UPDATE user SET `firstname`=:firstname, `lastname`=:lastname, `username`=:username WHERE id=:userId";

    $req = $this->pdo->prepare($sql);
    $req->bindParam(':firstname', $_POST["firstname"], PDO::PARAM_STR);
    $req->bindParam(':lastname', $_POST["lastname"], PDO::PARAM_STR);
    $req->bindParam(':username', $_POST["username"], PDO::PARAM_STR);
    $req->bindParam(':userId', $userId, PDO::PARAM_STR);
    $req->execute();
  }
}
