<?php

namespace App\Controllers;

use App\Core\Controller;

class IndexController extends Controller
{

    public function showHome()
    {
        $this->twig->display('client/pages/home.html.twig');
    }

    public function login()
    {
        $this->twig->display('client/pages/login.html.twig');
    }

    public function register()
    {
        $this->twig->display('client/pages/register.html.twig');
    }
}
