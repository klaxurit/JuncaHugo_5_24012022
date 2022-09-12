<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Service\SocialCRUD;
use App\Managers\PostManager;
use App\Managers\AdminManager;
use App\Managers\SocialManager;
use App\Managers\CommentManager;
use App\Managers\UserManager;
use App\Service\AdminProfile;
use App\Service\FileUploader;
use App\Exceptions\FileException;
use App\Model\Admin;
use App\Model\Social;

class AdminController extends Controller
{
    public const PER_PAGE = 10;

    /**
     * Return admin panel
     *
     * @return void
     */
    public function index()
    {
        $admin = (new AdminManager())->findAdmin();
        // Check if current user is admin
        if ($this->isAdmin()) {
            return $this->twig->display(
                'admin/index.html.twig',
                [
                    'admin' => $admin
                ]
            );
        }
    }

    /**
     * Update admin
     *
     * @return void
     */
    public function updateAdmin()
    {
        $adminDatas = (new AdminManager())->findAdmin($this->params['id']);
        $userDatas = (new UserManager())->findOneUser($adminDatas->getUserId());
        $adminDatas->setUser($userDatas);
        if (!empty($this->formDatas)) {
            $adminDatas->hydrate($this->formDatas);
            if (isset($this->formFiles["avatar_url"]) && $this->formFiles["avatar_url"]["name"] !== "") {
                $file = $this->formFiles["avatar_url"];
                try {
                    $filePath = (new FileUploader())->uploadFile($file, "image");
                } catch (FileException $e) {
                    $this->flash->set($e->getMessage(), 'error');
                    return header("Location: /admin");
                }
                $adminDatas->setAvatarUrl($filePath);
                (new AdminProfile())->updateAvatar($adminDatas);
            }
            if (isset($this->formFiles["cv_url"]) && $this->formFiles["cv_url"]["name"] !== "") {
                $file = $this->formFiles["cv_url"];
                try {
                    $filePath = (new FileUploader())->uploadFile($file, "document");
                } catch (FileException $e) {
                    $this->flash->set($e->getMessage(), 'error');
                    return header("Location: /admin");
                }
                $adminDatas->setCvUrl($filePath);
                (new AdminProfile())->updateCv($adminDatas);
            }
            $adminPwdConf = $this->formDatas["password_confirmation"];
            $errors = (new AdminProfile())->updateInfos($adminDatas, $adminPwdConf);
            if (empty($errors)) {
                $this->flash->set('L\'admin a bien été modifié.', 'success');
                return header('Location: /admin');
            }
        }

        return $this->twig->display(
            'admin/pages/profile/update.html.twig',
            [
                'admin' => $adminDatas,
                'errors' => $errors ?? []
            ]
        );
    }

    /**
     * Check if current user is admin
     *
     * @return void
     */
    public function isAdmin()
    {
        $admin = (new AdminManager())->findAdmin();
        $currentUser = $this->session->get("user");
        if (isset($currentUser) && ($currentUser->getId()) === $admin->getUserId()) {
            return true;
        }
        return header('Location: /');
    }

    /**
     * Return post's list
     *
     * @return void
     */
    public function managePosts()
    {
        // Find the current page
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $currentPage = (int) strip_tags($_GET['page']);
        } else {
            $currentPage = 1;
        }
        return $this->twig->display(
            'admin/pages/posts/index.html.twig',
            [
                'posts' => (new PostManager())->findAllPosts(self::PER_PAGE, $currentPage),
                'totalPages' => ceil((new PostManager())->countPosts() / self::PER_PAGE),
                "currentPage" => $currentPage
            ]
        );
    }

    /**
     * Return comment's list
     *
     * @return void
     */
    public function manageComments()
    {
        // Find the current page
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $currentPage = (int) strip_tags($_GET['page']);
        } else {
            $currentPage = 1;
        }
        return $this->twig->display(
            'admin/pages/comments/index.html.twig',
            [
                'comments' => (new CommentManager())->findAllComments(self::PER_PAGE, $currentPage),
                'totalPages' => ceil((new CommentManager())->countComments() / self::PER_PAGE),
                "currentPage" => $currentPage
            ]
        );
    }

    /**
     * Switch the comment's status
     *
     * @param  mixed $id
     * @return void
     */
    public function switchStatus()
    {
        $comment = (new CommentManager())->findOneComment($this->params['id']);
        $status = $comment->getStatus();
        if ($status === "1") {
            $status = "0";
        } else {
            $status = "1";
        }
        (new CommentManager())->updateComment($this->params['id'], $status);
        return $this->manageComments();
    }

    /**
     * Delete a comment
     *
     * @return void
     */
    public function adminDeleteComment()
    {
        (new CommentManager())->deleteComment($this->params['id']);
        $this->flash->set('Le commentaire a bien été supprimé.', 'success');

        header("Location: /admin/comments");
    }

    /**
     * Return social network's list
     *
     * @return void
     */
    public function manageSocials()
    {
        return $this->twig->display(
            'admin/pages/socials/index.html.twig',
            [
                'socials' => (new SocialManager())->findAllSocials()
            ]
        );
    }

    /**
     * Add a social network
     *
     * @return void
     */
    public function adminCreateSocial()
    {
        if (!empty($this->formDatas)) {
            $socialDatas = $this->formDatas;
            $social = new Social($socialDatas);
            // créer l'objet ici au lieu de le faire dans le manager
            $errors = (new SocialCRUD())->addSocial($social);
            if (empty($errors)) {
                $this->flash->set('Le réseau social a bien été créé.', 'success');
                return header("Location: /admin/socials");
            }
            $this->flash->set('Le réseau social n\'a pas été créé. Veuillez prendre en compte les différentes erreurs sous les champs concerné.', 'error');
        }

        return $this->twig->display(
            'admin/pages/socials/create.html.twig',
            [
                'errors' => $errors ?? []
            ]
        );
    }

    /**
     * Delete a social network
     *
     * @return void
     */
    public function adminDeleteSocial()
    {
        (new SocialManager())->deleteSocial($this->params['id']);
        $this->flash->set('Le réseau social a bien été supprimé.', 'success');

        return header('Location: /admin/socials');
    }

    /**
     * Update a social network
     *
     * @return void
     */
    public function adminUpdateSocial()
    {
        $socialDatas = (new SocialManager())->findOneSocial($this->params['id']);
        if (!empty($this->formDatas)) {
            $socialDatas->hydrate($this->formDatas);
            $errors = (new SocialCRUD())->modifySocial($socialDatas);
            if (empty($errors)) {
                $this->flash->set('Le réseau social a bien été modifié.', 'success');
                return header('Location: /admin/socials');
            }
        }

        return $this->twig->display(
            'admin/pages/socials/update.html.twig',
            [
                'social' => $socialDatas,
                'errors' => $errors ?? []
            ]
        );
    }
}
