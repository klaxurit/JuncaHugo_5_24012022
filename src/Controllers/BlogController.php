<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Managers\PostManager;
use App\Service\PaginationService;

class BlogController extends Controller
{


    /**
     * Return one post
     *
     * @return void
     */
    public function showPost()
    {
        $post = (new PostManager())->getPostBySlug($this->params['slug']);
        $this->twig->display('client/pages/blog/view.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * Return index of posts
     *
     * @return void
     */
    public function listPosts()
    {
        $paginate = (new PaginationService())->paginate();
        $posts = (new PostManager())->findAllPosts();
        $this->twig->display('client/pages/blog/index.html.twig', [
            'posts' => $posts,
            'paginate' => $paginate
        ]);
    }

    /**
     * Create a post
     *
     * @return void
     */
    public function createPost()
    {
        $this->twig->display('admin/pages/blog/create.html.twig');
    }

    /**
     * Update a post
     *
     * @return void
     */
    public function updatePost()
    {
        $this->twig->display('admin/pages/blog/update.html.twig');
    }

    /**
     * Delete a post
     *
     * @return void
     */
    public function deletePost()
    {
        $this->twig->display('admin/pages/blog/delete.html.twig');
    }
}
