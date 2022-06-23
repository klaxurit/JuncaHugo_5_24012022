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
    if (!empty($_POST)) {
      try {
        // Test si un email est présent
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) throw (new \Error("identifiants incorrects !"));
        // Email présent => On récupère un utilisateur avec l'email
        $user = (new UserManager())->loginUser();
        if ($user && password_verify($_POST["password"], $user["password"])) {
          // Si on a un utilisateur et que le mdp est bon => on se connecte.
          $_SESSION["user"] = [
            "id" => $user,
            "surnom" => $user["username"],
            "email" => $_POST["email"]
          ];
          // redirect user to home
          header("Location: /");
        } else {
          // Sinon erreur
          throw (new \Error("identifiants incorrects !"));
        }
      } catch (\Error $error) {
        $this->twig->display(
          'client/pages/login.html.twig',
          [
            'error' => $error->getMessage()
          ]
        );
      }
    } else {
      $this->twig->display(
        'client/pages/login.html.twig'
      );
    }
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
          $errors["email_invalid"] = "L'addresse email est incorrect.";
        }
        // check if entered password are the same
        if ($_POST["password_confirmation"] != $_POST["password"]) {
          $errors["passwords_are_same"] = "Les mots de passes entrés ne sont pas identiques.";
        }

        if (empty($errors)) {
          $user = (new UserManager())->createUser();
          // stock user's info in $_SESSION
          if ($user) {
            $_SESSION["user"] = [
              "id" => $user,
              "surnom" => $surnom,
              "email" => $_POST["email"]
            ];
          }
          // redirect user to home
          header("Location: /");
        }
      }
    }
    $this->twig->display(
      'client/pages/register.html.twig',
      [
        'errors' => $errors
      ]
    );
  }

  public function logout()
  {
    $user = (new UserManager())->logoutUser();
  }
}
