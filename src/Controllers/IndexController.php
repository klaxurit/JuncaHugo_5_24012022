<?php

namespace App\Controllers;

use App\Core\Controller;

class IndexController extends Controller
{

    public function showHome()
    {
        $this->twig->display('client/pages/home.html.twig');
    }
}
