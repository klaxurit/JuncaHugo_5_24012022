<?php

namespace App\Controllers;

use App\Core\Controller;

class BlogController extends Controller {

    public function showPost() {
        var_dump("Bienvenu sur le post");
        var_dump($this->params);
    }

    public function listPosts() {
        var_dump("Bienvenu sur la liste des posts");
    }

    public function createPost() {
        var_dump("Bienvenu sur la page de creation d'un post");
    }

    public function updatePost() {
        var_dump("Bienvenu sur la page de modification d'un post");
    }

    public function deletePost(){
        var_dump("Bienvenu sur la page de suppression d'un post");
    }
}