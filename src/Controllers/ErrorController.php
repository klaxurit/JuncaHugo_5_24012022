<?php

namespace App\Controllers;

use App\Core\Controller;

class ErrorController extends Controller
{
    /**
     * Return page 404
     *
     * @return void
     */
    public function show404()
    {
        $this->twig->display('client/errors/404.html.twig');
    }

    /**
     * Return page 403
     *
     * @return void
     */
    public function show403()
    {
        $this->twig->display('client/errors/403.html.twig');
    }

    /**
     * Return basic error page
     *
     * @return void
     */
    public function showError()
    {
        $this->twig->display('client/errors/error.html.twig', $this->params);
    }
}
