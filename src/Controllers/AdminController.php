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

  public function updateAdminInfos() {
    $adminDatas = (new AdminManager())->findAdmin($this->params['id']);
    $userDatas = (new UserManager())->findOneUser($adminDatas->getUserId());
    // die(var_dump($userDatas));
    if (!empty($_POST)) {
      $errors = (new AdminProfile())->updateInfos($adminDatas->getId(), $userDatas->getId());
      if (empty($errors)) {
        $this->flash->success('Le réseau social a bien été modifié.');
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
    if (isset($_SESSION['user']) && ($_SESSION['user']->getId()) === $admin->getUserId()) {
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
    $this->flash->success('Le commentaire a bien été supprimé.');

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
        $this->flash->success('Le réseau social a bien été créé.');
        return header("Location: /admin/socials");
      }
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
    $this->flash->success('Le réseau social a bien été supprimé.');

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
      $errors = (new SocialCRUD())->modifySocial($socialDatas->getId());
      if (empty($errors)) {
        $this->flash->success('Le réseau social a bien été modifié.');
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
