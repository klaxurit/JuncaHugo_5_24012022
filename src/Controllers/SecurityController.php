<?php

namespace App\Controllers;

use PDO;
use App\Model\User;
use App\Core\Controller;
use App\Managers\UserManager;
use App\Managers\AdminManager;
use App\Controllers\AdminController;
use App\Service\ValidationForm;

class SecurityController extends Controller
{

  /**
   * Return the login page
   *
   * @return voide
   */
  public function login()
  {
    if (!empty($_POST)) {
      try {
        // check if email exist and valid
        if (isset($_POST["email"])) {
          if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) throw (new \Error("identifiants incorrects !"));
        }
        // email ok => get user with email
        $user = (new UserManager())->loginUser();
        if (isset($_POST["password"])) {
            if ($user && password_verify($_POST["password"], $user->getPassword())) {
                // if user ok and password correct user connect and redirect.
                $this->session->set("user", $user);
                header("Location: /");
            } else {
                throw (new \Error("Identifiants incorrects !"));
            }
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
   * Return the register page
   *
   * @return void
   */
  public function register()
  {
    $validate = new ValidationForm();
    // Manage form errors
    if (!empty($_POST)) {
      $validate->checkRegister($_POST);
      
      if (!$validate->errors) {
        $user = (new UserManager())->createUser($_POST);
        $this->session->set("user", $user);
        header("Location: /");
      }
    }
    $this->twig->display(
      'client/pages/register.html.twig',
      [
        'errors' => $validate->errors
      ]
    );
  }

  /**
   * logout
   *
   * @return void
   */
  public function logout()
  {
    // Unset the user session
    $this->session->delete("user");
    // Redirect to home
    header("Location: /");
  }
}
