<?php

namespace App\Controllers;

use App\Core\Controller;

class IndexController extends Controller {

    public function showHome() {
        var_dump("Bienvenu sur la Home");
        die;
    }
}