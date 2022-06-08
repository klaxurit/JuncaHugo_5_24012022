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



    $user = (new UserManager())->createUser();
    $this->twig->display(
      'client/pages/register.html.twig',
      [
        'user' => $user,
        'errors' => $errors
      ]
    );
  }

  public function logout()
  {
    $user = (new UserManager())->logoutUser();
  }
}
