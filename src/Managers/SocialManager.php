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

    $id = $this->pdo->lastInsertId();

    $sql = "SELECT * FROM social_network WHERE id = :id";

    $req = $this->pdo->prepare($sql);
    $req->bindParam(':id', $id, PDO::PARAM_STR);
    $req->execute();
    $data = $req->fetch();

    $social = new Social($data);

    return $social;
  }

  /**
   * Update a social network
   *
   * @param  mixed $id
   * @return void
   */
  public function updateSocial(int $id)
  {
    $sql = "UPDATE social_network SET `icon_name`=:iconName, `url`=:socialUrl, `name`=:socialName WHERE id=:id";

    $req = $this->pdo->prepare($sql);
    $req->bindParam(':iconName', $_POST["iconName"], PDO::PARAM_STR);
    $req->bindParam(':socialUrl', $_POST["socialUrl"], PDO::PARAM_STR);
    $req->bindParam(':socialName', $_POST["socialName"], PDO::PARAM_STR);
    $req->bindParam('id', $id, PDO::PARAM_STR);
    $req->execute();
  }

  /**
   * Delete a social network
   *
   * @param  mixed $id
   * @return void
   */
  public function deleteSocial(int $id)
  {
    $sql = "DELETE FROM social_network WHERE id=:id";

    $req = $this->pdo->prepare($sql);
    $req->bindParam(':id', $id, PDO::PARAM_STR);
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
   * @param  mixed $id
   * @return void
   */
  public function findOneSocial(int $id)
  {
    $sql = "SELECT * FROM social_network WHERE id=:id";

    $req = $this->pdo->prepare($sql);
    $req->bindParam(':id', $id, PDO::PARAM_STR);
    $req->execute();

    $data = $req->fetch();

    $social = new Social($data);

    return $social;
  }
}
