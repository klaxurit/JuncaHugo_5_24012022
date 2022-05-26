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

    $this->twig->display('client/pages/login.html.twig');
  }

  /**
   * return the register page
   *
   * @return void
   */
  public function register()
  {
    $user = (new UserManager())->createUser();
    $this->twig->display(
      'client/pages/register.html.twig',
      [
        'user' => $user
      ]
    );
  }
}
