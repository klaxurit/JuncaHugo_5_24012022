<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Managers\CommentManager;
use App\Managers\PostManager;
use App\Service\PaginationService;
use Twig\Error\RuntimeError;

class BlogController extends Controller
{
    const PER_PAGE = 6;

    /**
     * Return one post
     *
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function showPost()
    {
        $post = (new PostManager())->getPostBySlug($this->params['slug']);
        $this->twig->display('client/pages/blog/view.html.twig', [
            'post' => $post,
            // 'comments' => (new CommentManager())->getCommentByPostId($post->getId())
        ]);
    }

    /**
     * Return index of posts
     *
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function listPosts()
    {
        // determinate what is the current page
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $currentPage = (int)strip_tags($_GET['page']);
        } else {
            $currentPage = 1;
        }

        $this->twig->display(
            'client/pages/blog/index.html.twig',
            [
                'posts' => (new PostManager())->findAllPosts(self::PER_PAGE, $currentPage),
                'totalPages' => ceil((new PostManager())->countPosts() / self::PER_PAGE),
                "currentPage" => $currentPage
            ]
        );
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
