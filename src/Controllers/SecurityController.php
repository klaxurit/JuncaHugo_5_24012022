<?php

namespace App\Controllers;

use App\Model\User;
use App\Core\Controller;

class SecurityController extends Controller
{

  /**
   * Return the login page
   *
   * @return void
   */
  public function login()
  {

    $this->twig->display('client/pages/login.html.twig');
  }

  /**
   * return the register page
   *
   * @return void
   */
  public function register()
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

        $sql = "INSERT INTO `user`(`nom`, `prenom`, `surnom`, `email`, `password`) VALUES (:nom, :prenom, :surnom, :email, '$password')";
        $req = $this->pdo->prepare();
      } else {
        die("Le formulaire est incomplet");
      }
    }
    $this->twig->display('client/pages/register.html.twig');
  }
}
