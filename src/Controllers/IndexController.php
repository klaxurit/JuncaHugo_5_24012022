<?php

namespace App\Controllers;

use App\Core\Controller;

class IndexController extends Controller
{

    /**
     * Return the home page
     *
     * @return void
     */
    public function showHome()
    {
        $this->twig->display('client/pages/home.html.twig');
    }
    
    public function contact()
    {
        $this->twig->display('client/pages/contact.html.twig');
    }
}
