<?php

namespace App\Controllers;

use App\Core\Controller;

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
        // var_dump($this->params);
    }
    
    /**
     * Return index of posts
     *
     * @return void
     */
    public function listPosts()
    {
        $this->twig->display('client/pages/index.html.twig');
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
