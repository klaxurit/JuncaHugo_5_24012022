<?php

namespace App\Controllers;

use App\Core\Controller;

class BlogController extends Controller {

    public function showPost() {
        var_dump("Bienvenu sur le post");
        var_dump($this->params);
    }

    public function listPosts() {
        $this->twig->display('admin/pages/index.html.twig');
    }

    public function createPost() {
        $this->twig->display('admin/pages/create.html.twig');
    }

    public function updatePost() {
        $this->twig->display('admin/pages/update.html.twig');
    }

    public function deletePost(){
        $this->twig->display('admin/pages/delete.html.twig');
    }
}