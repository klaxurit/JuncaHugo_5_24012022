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
    // check if form has been sent
    if (!empty($_POST)) {
      // form has been sent
      // check if all reaquired field are completed
      if (
        isset($_POST["nom"], $_POST["prenom"], $_POST["surnom"], $_POST["email"], $_POST["password"])
        && !empty($_POST["nom"])
        && !empty($_POST["prenom"])
        && !empty($_POST["surnom"])
        && !empty($_POST["email"])
        && !empty($_POST["password"])
      ) {
        // form is complete
        // get & protect datas
        $nom = strip_tags($_POST["nom"]);
        $prenom = strip_tags($_POST["prenom"]);
        $surnom = strip_tags($_POST["surnom"]);

        // email must be an email
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
          die("L'addresse email est incorrect.");
        }

        // hash password using password ARGON2ID 
        // (ARGON2ID algorithm most powerfull than BCRYPT and ARGON2I)
        $password = password_hash($_POST["password"], PASSWORD_ARGON2ID);

        // check if entered password are the same
        if ($_POST["password_confirmation"] != $_POST["password"]) {
          die("Les mots de passe entrés sont différents");
        }

        $sql = "INSERT INTO `user`(`firstname`, `lastname`, `username`, `email`, `password`) VALUES (:nom, :prenom, :surnom, :email, '$password')";
        $req = $this->pdo->prepare($sql);
        $req->bindParam(':nom', $nom, PDO::PARAM_STR);
        $req->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $req->bindParam(':surnom', $surnom, PDO::PARAM_STR);
        $req->bindParam(':email', $_POST["email"], PDO::PARAM_STR);

        $req->execute();

        // get new user's id
        $id = $this->pdo->lastInsertId();

        // stock user's info in $_SESSION
        $_SESSION["user"] = [
          "id" => $id,
          "surnom" => $surnom,
          "email" => $_POST["email"]
        ];

        // redirect user to home
        header("Location: /");
      } else {
        die("Le formulaire est incomplet");
      }
    }
  }

  public function loginUser()
  {
    // check if form has been sent
    if (!empty($_POST)) {
      // form has been sent
      // check if all reaquired field are completed
      if (
        isset($_POST["email"], $_POST["password"])
        && !empty($_POST["email"] && !empty($_POST["password"]))
      ) {
        // email must be an email
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
          die("Ce n'est pas un email");
        }

        $sql = "SELECT * FROM `user` WHERE `email` = :email";
        $req = $this->pdo->prepare($sql);
        $req->bindParam(':email', $_POST["email"], PDO::PARAM_STR);

        $req->execute();
        $user = $req->fetch();

        // check if user data exist
        if (!$user) {
          die("L'utilisateur et/ou le mot de passe est incorrect");
        }

        // check if password is OK
        if (!password_verify($_POST["password"], $user["password"])) {
          die("L'utilisateur et/ou le mot de passe est incorrect");
        }
        // user is connected

        // stock user's info in $_SESSION
        $_SESSION["user"] = [
          "id" => $user["id"],
          "surnom" => $user["username"],
          "email" => $user["email"]
        ];

        // redirect user to home
        header("Location: /");
      }
    }
  }

  public function logoutUser()
  {
    // unset the user session
    unset($_SESSION["user"]);
    // redirect to home
    header("Location: /");
  }
}
