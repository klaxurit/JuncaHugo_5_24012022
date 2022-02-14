<?php

namespace App\Controllers;

use App\Core\Controller;

class IndexController extends Controller {

    public function showHome() {
        var_dump("Bienvenu sur la Home");
        die;
    }

    public function login() {
        var_dump("Bienvenu sur la page de Log In");
    }

    public function register() {
        var_dump("Bienvenu sur la page d'inscription");
    }
}