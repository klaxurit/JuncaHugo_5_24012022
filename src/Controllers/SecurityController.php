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
        // check if email exist and valid
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) throw (new \Error("identifiants incorrects !"));
        // email ok => get user with email
        $user = (new UserManager())->loginUser();
        if ($user && password_verify($_POST["password"], $user->getPassword())) {
          // if user ok and password correct user connect and redirect.
          $_SESSION["user"] = [
            "id" => $user->getId(),
            "surnom" => $user->getUsername(),
            "email" => $user->getEmail()
          ];
          header("Location: /");
        } else {
          throw (new \Error("Identifiants incorrects !"));
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
      if (empty($_POST["lastName"])) {
        $errors["lastName"] = "Le champ \"Nom\" est requis.";
      }
      if (empty($_POST["firstName"])) {
        $errors["firstName"] = "Le champ \"Prenom\" est requis.";
      }
      if (empty($_POST["username"])) {
        $errors["username"] = "Le champ \"Surnom\" est requis.";
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
      if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors["email_invalid"] = "L'addresse email est incorrect.";
      }
      // check if entered password are the same
      if ($_POST["password_confirmation"] != $_POST["password"]) {
        $errors["passwords_are_same"] = "Les mots de passes entrés ne sont pas identiques.";
      }
      if (!$errors) {
        foreach ($_POST as $key => $value) {
          $_POST[$key] = strip_tags($value);
        }
        $user = (new UserManager())->createUser($_POST);
        $_SESSION["user"] = $user;
        header("Location: /");
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
    // unset the user session
    unset($_SESSION["user"]);
    // redirect to home
    header("Location: /");
  }
}
