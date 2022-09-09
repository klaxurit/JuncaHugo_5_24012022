<?php

namespace App\Managers;

use App\Core\Entity;
use PDO;
use App\Core\Manager;
use App\Model\Social;

class SocialManager extends Manager
{
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Create a social network
   *
   * @param  mixed $social
   * @return void
   */
  public function createSocial($social)
  {
    $social = new Social($social);

    $sql = "INSERT INTO `social_network`(`icon_name`, `url`, `name`) VALUES (:iconName, :url, :name)";

    $req = $this->pdo->prepare($sql);
    $req->bindValue(':iconName', $social->getIconName(), PDO::PARAM_STR);
    $req->bindValue(':url', $social->getUrl(), PDO::PARAM_STR);
    $req->bindValue(':name', $social->getName(), PDO::PARAM_STR);
    $req->execute();

    $socialId = $this->pdo->lastInsertId();

    $sql = "SELECT * FROM social_network WHERE id = :id";

    $req = $this->pdo->prepare($sql);
    $req->bindParam(':id', $socialId, PDO::PARAM_STR);
    $req->execute();

    return $social;
  }



  /**
   * Update a social network
   *
   * @param  mixed $socialDatas
   * @return void
   */
  public function updateSocial($socialDatas)
  {
    $sql = "UPDATE `social_network` SET `icon_name`=:iconName, `url`=:url, `name`=:name WHERE `id`=:id";

    $req = $this->pdo->prepare($sql);
    $req->bindValue(':iconName', $socialDatas->getIconName(), PDO::PARAM_STR);
    $req->bindValue(':url', $socialDatas->getUrl(), PDO::PARAM_STR);
    $req->bindValue(':name', $socialDatas->getName(), PDO::PARAM_STR);
    $req->bindValue(':id', $socialDatas->getId(), PDO::PARAM_STR);
    $req->execute();
  }

  /**
   * Delete a social network
   *
   * @param  mixed $socialId
   * @return void
   */
  public function deleteSocial(int $socialId)
  {
    $sql = "DELETE FROM social_network WHERE id=:id";

    $req = $this->pdo->prepare($sql);
    $req->bindParam(':id', $socialId, PDO::PARAM_STR);
    $req->execute();
  }

  /**
   * Find all socials
   *
   * @return void
   */
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

  /**
   * Find social by id
   *
   * @param  mixed $socialId
   * @return void
   */
  public function findOneSocial(int $socialId)
  {
    $sql = "SELECT * FROM social_network WHERE id=:id";

    $req = $this->pdo->prepare($sql);
    $req->bindParam(':id', $socialId, PDO::PARAM_STR);
    $req->execute();

    $data = $req->fetch();

    $social = new Social($data);

    return $social;
  }
}
