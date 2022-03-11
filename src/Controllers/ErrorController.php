<?php

namespace App\Controllers;

use App\Core\Controller;

class ErrorController extends Controller
{
    
    /**
     * Return a 404 Error page
     *
     * @return void
     */
    public function show404()
    {
        $this->twig->display('client/errors/404.html.twig');
    }

    public function showError()
    {
        $this->twig->display('client/errors/error.html.twig.', $this->params);
    }
}
