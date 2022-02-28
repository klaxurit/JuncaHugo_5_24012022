<?php

namespace App\Controllers;

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
      $this->twig->display('client/pages/register.html.twig');
  }
}
