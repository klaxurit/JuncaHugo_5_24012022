<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Managers\PostManager;

class BlogController extends Controller
{


    /**
     * Return one post
     *
     * @return void
     */
    public function showPost()
    {
        $this->twig->display('client/pages/posts/view.html.twig', $this->params);
        // var_dump();
    }

    /**
     * Return index of posts
     *
     * @return void
     */
    public function listPosts()
    {
        $posts = (new PostManager())->findPost();

        $this->twig->display('client/pages/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * Create a post
     *
     * @return void
     */
    public function createPost()
    {
        $this->twig->display('admin/pages/posts/create.html.twig');
    }

    /**
     * Update a post
     *
     * @return void
     */
    public function updatePost()
    {
        $this->twig->display('admin/pages/posts/update.html.twig');
    }

    /**
     * Delete a post
     *
     * @return void
     */
    public function deletePost()
    {
        $this->twig->display('admin/pages/posts/delete.html.twig');
    }
}
