<?php

namespace App\Managers;

use PDO;
use App\Core\Manager;
use App\Model\Social;

class SocialManager extends Manager
{
  public function __construct()
  {
    parent::__construct();
  }

  public function createSocial($social)
  {
    $sql = "INSERT INTO `social_network`(`icon_name`, `url`, `name`) VALUES (:iconName, :socialUrl, :socialName)";

    $req = $this->pdo->prepare($sql);
    $req->bindParam(':iconName', $social["iconName"], PDO::PARAM_STR);
    $req->bindParam(':socialUrl', $social["socialUrl"], PDO::PARAM_STR);
    $req->bindParam(':socialName', $social["socialName"], PDO::PARAM_STR);
    $req->execute();

    $id = $this->pdo->lastInsertId();

    $sql = "SELECT * FROM social_network WHERE id = :id";
    $req = $this->pdo->prepare($sql);
    $req->bindParam(':id', $id, PDO::PARAM_STR);
    $req->execute();
    $data = $req->fetch();

    $social = new Social($data);

    return $social;
  }

  public function findAllSocials()
  {
    $sql = "SELECT * FROM social_network";
    $req = $this->pdo->prepare($sql);
    $req->execute();
    $datas = $req->fetchAll();
    $socials = [];
    
    foreach ($datas as $data) {
      $social = new Social($data);
      
      array_push($socials, $social);
    }

    return $socials;
  }
}