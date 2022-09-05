<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Managers\AdminManager;
use App\Service\AddComment;
use App\Managers\PostManager;
use App\Managers\CommentManager;
use App\Service\PostCRUD;
use App\Service\FileUploader;
use App\Exceptions\WrongFileTypeException;
use App\Exceptions\WrongFileSizeException;
use App\Exceptions\DownloadFileFailedException;
use Cocur\Slugify\Slugify;

class BlogController extends Controller
{
    const PER_PAGE = 6;
    
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
            if (!empty($_POST)) {
                $commentDatas = $_POST;
                $errors = (new AddComment())->add($post->getId(), $commentDatas);
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
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $currentPage = (int) strip_tags($_GET['page']);
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
        if (!empty($_POST)) {
            $postDatas = $_POST;
            if (isset($_FILES["cover_image"]) && isset($_FILES["cover_image"]["name"]) && $_FILES["cover_image"]["name"] !== "") {
                $file = $_FILES["cover_image"];
                try {
                    list($filePath) = (new FileUploader())->uploadFile($file, "image");
                } catch (WrongFileTypeException | WrongFileSizeException | DownloadFileFailedException $e) {
                    $this->flash->set($e->getMessage(), 'error');
                    return header("Location: /admin/posts");
                }

                $slugify = new Slugify();
                $postDatas["slug"] = $slugify->slugify($postDatas["title"]);
                $admin = (new AdminManager())->findAdmin();
                $postDatas["cover_image"] = "$filePath";
                $postDatas["user_id"] = $admin->getUserId();
            }
            $errors = (new PostCRUD())->addPost($postDatas);
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
        if (!empty($_POST)) {
            $postDatas->hydrate($_POST);
            if (isset($_FILES["cover_image"]) && $_FILES["cover_image"]["name"] !== "") {
                $file = $_FILES["cover_image"];
                try {
                    list($filePath) = (new FileUploader())->uploadFile($file, "image");
                } catch (WrongFileTypeException | WrongFileSizeException | DownloadFileFailedException $e) {
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
}
