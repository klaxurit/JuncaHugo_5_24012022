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
    $users = new User($datas);

    return $users;
  }

  public function findOneUser(int $id)
  {
    $sql = "SELECT * FROM user WHERE id=:id";

    $req = $this->pdo->prepare($sql);
    $req->bindParam(':id', $id, PDO::PARAM_STR);
    $req->execute();

    $data = $req->fetch();

    $user = new User($data);

    return $user;
  }

  /**
   * add a new user in db
   *
   * @return void
   */
  public function createUser($user)
  {
    // hash password using password ARGON2ID 
    // (ARGON2ID algorithm most powerfull than BCRYPT and ARGON2I)
    $password = password_hash($user["password"], PASSWORD_ARGON2ID);

    $sql = "INSERT INTO `user`(`firstname`, `lastname`, `username`, `email`, `password`) VALUES (:lastName, :firstName, :username, :email, :pass)";
    $req = $this->pdo->prepare($sql);
    $req->bindParam(':lastName', $user["lastName"], PDO::PARAM_STR);
    $req->bindParam(':firstName', $user["firstName"], PDO::PARAM_STR);
    $req->bindParam(':username', $user["username"], PDO::PARAM_STR);
    $req->bindParam(':email', $user["email"], PDO::PARAM_STR);
    $req->bindParam(':pass', $password, PDO::PARAM_STR);

    $req->execute();


    // get new user's id
    $id = $this->pdo->lastInsertId();

    $sql = "SELECT * FROM user WHERE id = :id";
    $req = $this->pdo->prepare($sql);
    $req->bindParam(':id', $id, PDO::PARAM_STR);
    $req->execute();
    $data = $req->fetch();

    $user = new User($data);

    return $user;
  }

  public function loginUser()
  {
    $sql = "SELECT * FROM `user` WHERE `email` = :email";
    $req = $this->pdo->prepare($sql);
    $req->bindParam(':email', $_POST["email"], PDO::PARAM_STR);

    $req->execute();
    $datas = $req->fetch();

    return ($datas) ? new User($datas) : null;
  }
}
