<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Managers\UserManager;
use App\Managers\AdminManager;
use App\Managers\SocialManager;
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
        $socials = (new SocialManager())->findAllSocials();
        $admin = (new AdminManager())->findAdmin();
        $this->twig->display(
            'client/pages/home.html.twig',
            [
                'admin' => $admin,
                'socials' => $socials
            ]
        );
    }
}
