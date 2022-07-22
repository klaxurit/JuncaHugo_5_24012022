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

  public function updateAdmin(int $id)
  {
    $sql = "UPDATE admin SET `description`=:adminDesc, `tagline`=:tagline, `avatar_url`=:avatarUrl, `avatar_alt`=:avatarAlt, `cv_url`=:cvUrl WHERE id=:id";

    $req = $this->pdo->prepare($sql);
    $req->bindParam(':adminDesc', $_POST["adminDesc"], PDO::PARAM_STR);
    $req->bindParam(':tagline', $_POST["tagline"], PDO::PARAM_STR);
    $req->bindParam(':avatarUrl', $_POST["avatarUrl"], PDO::PARAM_STR);
    $req->bindParam(':avatarAlt', $_POST["avatarAlt"], PDO::PARAM_STR);
    $req->bindParam(':cvUrl', $_POST["cvUrl"], PDO::PARAM_STR);
    $req->bindParam('id', $id, PDO::PARAM_STR);
    $req->execute();
  }
}
