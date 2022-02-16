<?php

namespace App\Controllers;

use App\Core\Controller;

class IndexController extends Controller {

    public function showHome() {
        $this->twig->display('admin/pages/home.html.twig');
    }

    public function login() {
        $this->twig->display('admin/pages/login.html.twig');
    }

    public function register() {
        $this->twig->display('admin/pages/register.html.twig');
    }
}