<?php

namespace App\Controllers;

use App\Core\Controller;

class SecurityController extends Controller
{

  public function login()
  {
      $this->twig->display('client/pages/login.html.twig');
  }

  public function register()
  {
      $this->twig->display('client/pages/register.html.twig');
  }
}
