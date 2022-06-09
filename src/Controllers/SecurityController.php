<?php

namespace App\Controllers;

use PDO;
use App\Model\User;
use App\Core\Controller;
use App\Managers\UserManager;

class SecurityController extends Controller
{

  /**
   * Return the login page
   *
   * @return void
   */
  public function login()
  {
    $user = (new UserManager())->loginUser();
    $this->twig->display(
      'client/pages/login.html.twig',
      [
        'user' => $user
      ]
    );
  }

  /**
   * return the register page
   *
   * @return void
   */
  public function register()
  {
    // manage form errors
    $errors = [];
    if (!empty($_POST)) {
      if (empty($_POST["nom"])) {
        $errors["nom"] = "Le champ \"Nom\" est requis.";
      }
      if (empty($_POST["prenom"])) {
        $errors["prenom"] = "Le champ \"Prenom\" est requis.";
      }
      if (empty($_POST["surnom"])) {
        $errors["surnom"] = "Le champ \"Surnom\" est requis.";
      }
      if (empty($_POST["email"])) {
        $errors["email"] = "Le champ \"Email\" est requis.";
      }
      if (empty($_POST["password"])) {
        $errors["password"] = "Le champ \"Mot de passe\" est requis.";
      }
      if (empty($_POST["password_confirmation"])) {
        $errors["password_confirmation"] = "Le champ \"Confirmez le mdp\" est requis.";
      }
    }

    // check if form has been sent
    if (!empty($_POST)) {
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

        // // hash password using password ARGON2ID 
        // // (ARGON2ID algorithm most powerfull than BCRYPT and ARGON2I)
        // $password = password_hash($_POST["password"], PASSWORD_ARGON2ID);

        // check if entered password are the same
        if ($_POST["password_confirmation"] != $_POST["password"]) {
          die("Les mots de passe entrés sont différents");
        }

        if (empty($errors)) {

          $user = (new UserManager())->createUser();

          if ($user) {
            $_SESSION["user"] = [
              "id" => $user,
              "surnom" => $surnom,
              "email" => $_POST["email"]
            ];
          }

          // get new user's id
          // $id = $this->pdo->lastInsertId();

          // stock user's info in $_SESSION


          // redirect user to home
          header("Location: /");
        } else {
          die("Le formulaire est incomplet");
        }
      }
    }

    // $user = (new UserManager())->createUser();
    $this->twig->display(
      'client/pages/register.html.twig',
      [
        // 'user' => $_SESSION["user"],
        'errors' => $errors
      ]
    );
  }

  public function logout()
  {
    $user = (new UserManager())->logoutUser();
  }
}
