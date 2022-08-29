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

  public function updateAdminInfos($adminDatas)
  {
    $sql = "UPDATE admin 
    INNER JOIN user 
    ON user.id = admin.user_id 
    SET admin.description=:description, admin.tagline=:tagline, user.firstname=:firstname, user.lastname=:lastname, user.username=:username
    WHERE admin.id=:id";

    $req = $this->pdo->prepare($sql);
    $req->bindValue(':description', $adminDatas->getDescription(), PDO::PARAM_STR);
    $req->bindValue(':tagline', $adminDatas->getTagline(), PDO::PARAM_STR);
    $req->bindValue(':firstname', $adminDatas->getFirstname(), PDO::PARAM_STR);
    $req->bindValue(':lastname', $adminDatas->getLastname(), PDO::PARAM_STR);
    $req->bindValue(':username', $adminDatas->getUsername(), PDO::PARAM_STR);
    $req->bindValue(':id', $adminDatas->getId(), PDO::PARAM_STR);
    $req->execute();
  }

  public function updateAdminAvatar($adminDatas)
  {
    $sql = "UPDATE admin
    SET admin.avatar_url=:avatar_url
    WHERE admin.id=:id";

  $req = $this->pdo->prepare($sql);
  $req->bindValue(':avatar_url', $adminDatas->getAvatarUrl(), PDO::PARAM_STR);
  $req->bindValue(':id', $adminDatas->getId(), PDO::PARAM_STR);
  $req->execute();
  }

  public function updateAdminCv($adminDatas)
  {
    $sql = "UPDATE admin
    SET admin.cv_url=:cv_url
    WHERE admin.id=:id";

  $req = $this->pdo->prepare($sql);
  $req->bindValue(':cv_url', $adminDatas->getCvUrl(), PDO::PARAM_STR);
  $req->bindValue(':id', $adminDatas->getId(), PDO::PARAM_STR);
  $req->execute();
  }
}
