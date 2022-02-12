<?php

namespace App\Controllers;

use App\Core\Controller;

class BlogController extends Controller {

    public function showPost() {
        var_dump("Bienvenu sur le post");
        var_dump($this->params);
        die;
    }
}