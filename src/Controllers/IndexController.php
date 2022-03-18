<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Managers\UserManager;
use App\Managers\AdminManager;
use App\Model\Admin;

class IndexController extends Controller
{

    /**
     * Return the home page
     *
     * @return void
     */
    public function showHome()
    {
        // var_dump((new UserManager())->findUsers());
        var_dump((new AdminManager())->findAdmin());
        $this->twig->display('client/pages/home.html.twig');
    }
}
