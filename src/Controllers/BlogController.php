<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Managers\AdminManager;
use App\Service\AddComment;
use App\Managers\PostManager;
use App\Managers\CommentManager;
use App\Service\PostCRUD;
use App\Service\FileUploader;
use App\Exceptions\FileException;
use Cocur\Slugify\Slugify;
use App\Service\SendMail;
use PHPMailer\PHPMailer\Exception;
use App\Model\Post;

class BlogController extends Controller
{
    public const PER_PAGE = 6;

    /**
     * Return view of a post and comments
     *
     * @return void
     */
    public function showPost()
    {
        $post = (new PostManager())->getPostBySlug($this->params['slug']);
        $comments = (new CommentManager())->getCommentsByPostId($post->getId());
        if (null !== $this->session->get("user")) {
            if (!empty($this->formDatas)) {
                $this->formDatas["content"] = htmlspecialchars_decode($this->formDatas["content"]);
                $errors = (new AddComment())->add($post->getId(), $this->formDatas);
            }
        }

        $this->twig->display('client/pages/blog/view.html.twig', [
            'post' => $post,
            'comments' => $comments,
            'errors' => $errors ?? []
        ]);
    }

    /**
     * Return articles's list
     *
     * @return void
     */
    public function listPosts()
    {
        // Find the current page
        if (isset($this->getUrl['page']) && !empty($this->getUrl['page'])) {
            $currentPage = (int) strip_tags($this->getUrl['page']);
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
        if (!empty($this->formDatas)) {
            $post = new Post($this->formDatas);
            if (isset($this->formFiles["cover_image"]) && isset($this->formFiles["cover_image"]["name"]) && $this->formFiles["cover_image"]["name"] !== "") {
                $file = $this->formFiles["cover_image"];
                try {
                    $filePath = (new FileUploader())->uploadFile($file, "image");
                } catch (FileException $e) {
                    $this->flash->set($e->getMessage(), 'error');
                    return header("Location: /admin/posts");
                }

                $slugify = new Slugify();
                $post->setSlug($slugify->slugify($post->getTitle()));
                $admin = (new AdminManager())->findAdmin();
                $post->setCoverImage("$filePath");
                $post->setUserId($admin->getUserId());
            }
            $errors = (new PostCRUD())->addPost($post);
            if (empty($errors)) {
                $this->flash->set('L\'article a bien été créé.', 'success');
                return header("Location: /admin/posts");
            }
            $this->flash->set('L\'article n\'a pas été créé. Veuillez prendre en compte les différentes erreurs sous les champs concerné.', 'error');
        }

        return $this->twig->display(
            'admin/pages/posts/create.html.twig',
            [
                'errors' => $errors ?? []
            ]
        );
    }

    /**
     * Update a post
     *
     * @return void
     */
    public function updatePost()
    {
        $postDatas = (new PostManager())->findOnePost($this->params['id']);
        if (!empty($this->formDatas)) {
            $postDatas->hydrate($this->formDatas);
            if (isset($this->formFiles["cover_image"]) && $this->formFiles["cover_image"]["name"] !== "") {
                $file = $this->formFiles["cover_image"];
                try {
                    $filePath = (new FileUploader())->uploadFile($file, "image");
                } catch (FileException $e) {
                    $this->flash->set($e->getMessage(), 'error');
                    return header("Location: /admin/posts");
                }

                $slugify = new Slugify();
                $postDatas->setSlug($slugify->slugify($postDatas->getTitle()));
                $admin = (new AdminManager())->findAdmin();
                $postDatas->setCoverImage($filePath);
                $postDatas->setUserId($admin->getUserId());
            }
            $errors = (new PostCRUD())->updatePost($postDatas);
            if (empty($errors)) {
                $this->flash->set('L\'article a bien été modifié.', 'success');
                return header('Location: /admin/posts');
            }
        }

        return $this->twig->display(
            'admin/pages/posts/update.html.twig',
            [
                'post' => $postDatas,
                'errors' => $errors ?? []
            ]
        );
        $this->twig->display('admin/pages/posts/update.html.twig');
    }

    /**
     * Delete a post
     *
     * @return void
     */
    public function deletePost()
    {
        (new PostManager())->deletePost($this->params['id']);
        $this->flash->set('L\'article a bien été supprimé.', 'success');

        return header('Location: /admin/posts');
    }

    /**
     * send contact email
     *
     * @return void
     */
    public function contactMe()
    {
        if (!empty($this->formDatas)) {
            $mailDatas = $this->formDatas;
            try {
                (new SendMail())->newMail($mailDatas);
            } catch (Exception $e) {
                $this->flash->set($e->getMessage(), 'error');
                return header("Location: /");
            }
        }
        $this->flash->set("Message envoyé!", 'success');
        return header("Location: /");
    }
}
