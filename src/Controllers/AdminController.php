<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Router;
use App\Service\SocialCRUD;
use App\Managers\PostManager;
use App\Managers\AdminManager;
use App\Managers\SocialManager;
use App\Managers\CommentManager;
use App\Managers\UserManager;
use App\Service\AdminProfile;
use App\Session\PHPSession;

class AdminController extends Controller
{
    const PER_PAGE = 10;

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

    public function updateAdminInfos()
    {
        $adminDatas = (new AdminManager())->findAdmin($this->params['id']);
        $userDatas = (new UserManager())->findOneUser($adminDatas->getUserId());
        $adminDatas->setUser($userDatas);
        if (!empty($_POST)) {
            $adminDatas->hydrate($_POST);
            $errors = (new AdminProfile())->updateInfos($adminDatas);
            if (empty($errors)) {
                $this->flash->set('Le réseau social a bien été modifié.', 'success');
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

    public function updateAdminFiles()
    {
        $adminDatas = (new AdminManager())->findAdmin($this->params['id']);
        if (!empty($_POST)) {
            // var_dump($_FILES["monfichier"]["error"]);
            // die();
            if(isset($_FILES["monfichier"]) && $_FILES["monfichier"]["error"] === 0) {
                // On a recu le fichier
                // On procède aux vérifications
                // On vérifie toujours l'extension et le type mime
                $allowed = [
                    "jpg" => "image/jpeg",
                    "jpeg" => "image/jpeg",
                    "png" => "image/png",
                    "pdf" => "application/pdf"
                ];
                // var_dump("mes couuilles");
                // die();
                $fileName = $_FILES["monfichier"]["name"];
                $fileType = $_FILES["monfichier"]["type"];
                $fileSize = $_FILES["monfichier"]["size"];
                
                $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                // On vérifie l'absence de l'etension dans les clefs $allowed ou l'bsence du type mime dans les valeurs
                if(!array_key_exists($extension, $allowed) || !in_array($fileType, $allowed)) {
                    // Ici soit l'extension soit le type est incorrect
                    $this->flash->set('Type de fichier non pris en compte.', 'error');
                    return header("Location: /admin");
                }
                // Ici le type est correct
                // On limite a 1Mo
                if($fileSize > 1024 * 1024) {
                    $this->flash->set('Fichier trop volumineux.', 'error');
                    return header("Location: /admin");
                }
                
                // On génère un nom unique
                $newName = md5(uniqid());
                
                // On génère le chemin complet
                $newFileName = ROOT_DIR . "/public/uploads/$newName.$extension";
                
                if(!move_uploaded_file($_FILES["monfichier"]["tmp_name"], $newFileName)) {
                    $this->flash->set('Le téléchargement du fichier a échoué.', 'error');
                    return header("Location: /admin");
                }
                
                // On protège l'utiliseur d'un éventuel script
                chmod($newFileName, 0644);
                
                $adminDatas->hydrate($_POST);
                $errors = (new AdminProfile())->updateFiles($adminDatas);
                // var_dump($adminDatas, "voila");
                // die();

            }
            // if (empty($errors)) {
            //     $this->flash->set('Fichier(s) bien modifié !', 'success');
            //     return header('Location: /admin');
            // }
        }

        return $this->twig->display(
            'admin/pages/profile/updateFiles.html.twig',
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
        } else {
            return header('Location: /');
        }
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
            $currentPage = (int)strip_tags($_GET['page']);
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
            $currentPage = (int)strip_tags($_GET['page']);
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
        if (!empty($_POST)) {
            $errors = (new SocialCRUD())->addSocial();
            if (empty($errors)) {
                $this->flash->set('Le réseau social a bien été créé.', 'success');
                return header("Location: /admin/socials");
            }
            $this->flash->set('Le réseau social n\'a pas été créé. Veuillez prendre en compte les différentes erreurs sous les champs concerné.', 'error');
        }

        return $this->twig->display(
            'admin/pages/socials/form.html.twig',
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
        if (!empty($_POST)) {
            $socialDatas->hydrate($_POST);
            $errors = (new SocialCRUD())->modifySocial($socialDatas);
            if (empty($errors)) {
                $this->flash->set('Le réseau social a bien été modifié.', 'success');
                return header('Location: /admin/socials');
            }
        }

        return $this->twig->display(
            'admin/pages/socials/form.html.twig',
            [
                'social' => $socialDatas,
                'errors' => $errors ?? []
            ]
        );
    }
}
