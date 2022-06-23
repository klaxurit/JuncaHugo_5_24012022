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

  /**
   * add a new user in db
   *
   * @return void
   */
  public function createUser()
  {
    // hash password using password ARGON2ID 
    // (ARGON2ID algorithm most powerfull than BCRYPT and ARGON2I)
    $password = password_hash($_POST["password"], PASSWORD_ARGON2ID);

    $sql = "INSERT INTO `user`(`firstname`, `lastname`, `username`, `email`, `password`) VALUES (:nom, :prenom, :surnom, :email, '$password')";
    $req = $this->pdo->prepare($sql);
    $req->bindParam(':nom', $_POST["nom"], PDO::PARAM_STR);
    $req->bindParam(':prenom', $_POST["prenom"], PDO::PARAM_STR);
    $req->bindParam(':surnom', $_POST["surnom"], PDO::PARAM_STR);
    $req->bindParam(':email', $_POST["email"], PDO::PARAM_STR);

    $req->execute();

    // get new user's id
    $id = $this->pdo->lastInsertId();

    return $id;
  }

  public function loginUser()
  {
    $sql = "SELECT * FROM `user` WHERE `email` = :email";
    $req = $this->pdo->prepare($sql);
    $req->bindParam(':email', $_POST["email"], PDO::PARAM_STR);

    $req->execute();
    $user = $req->fetch();
    $user = new User();

    return $user;
  }
}
