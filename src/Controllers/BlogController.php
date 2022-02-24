<?php

namespace App\Controllers;

use App\Core\Controller;

class BlogController extends Controller
{

    public function showPost()
    {
        $this->twig->display('client/pages/posts/view.html.twig', $this->params);
        // var_dump($this->params);
    }

    public function listPosts()
    {
        $this->twig->display('client/pages/index.html.twig');
    }

    public function createPost()
    {
        $this->twig->display('admin/pages/posts/create.html.twig');
    }

    public function updatePost()
    {
        $this->twig->display('admin/pages/posts/update.html.twig');
    }

    public function deletePost()
    {
        $this->twig->display('admin/pages/posts/delete.html.twig');
    }
}
