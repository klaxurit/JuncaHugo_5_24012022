<?php

namespace App\Controllers;

use App\Model\Comment;
use App\Core\Controller;
use App\Managers\PostManager;
use App\Managers\AdminManager;
use App\Managers\SocialManager;
use App\Service\ValidationForm;
use App\Managers\CommentManager;
use App\Service\SocialCRUD;

class AdminController extends Controller
{
  const PER_PAGE = 10;

  public function index()
  {
    //check if current user is admin
    if ($this->isAdmin()) {
      $this->twig->display('admin/index.html.twig');
    }
  }

  /**
   * check if current user is admin
   *
   * @return void
   */
  public function isAdmin()
  {
    $admin = (new AdminManager())->findAdmin();
    //check if user is conected and if he is admin
    if (isset($_SESSION['user']) && ($_SESSION['user']['id']) === $admin->getUserId()) {
      // is admin
      return true;
    } else {
      // is not admin
      $_SESSION['error'] = "Vous n'avez pas accès a l'administration.";
      header('Location: /');
    }
  }

  /**
   * Display all posts
   *
   * @return void
   */
  public function managePosts()
  {
    if ($this->isAdmin()) {
      // determinate what is the current page
      if (isset($_GET['page']) && !empty($_GET['page'])) {
        $currentPage = (int)strip_tags($_GET['page']);
      } else {
        $currentPage = 1;
      }
    }
    $this->twig->display(
      'admin/pages/posts/index.html.twig',
      [
        'posts' => (new PostManager())->findAllPosts(self::PER_PAGE, $currentPage),
        'totalPages' => ceil((new PostManager())->countPosts() / self::PER_PAGE),
        "currentPage" => $currentPage
      ]
    );
  }

  /**
   * Display all posts
   *
   * @return void
   */
  public function manageComments()
  {
    if ($this->isAdmin()) {
      // determinate what is the current page
      if (isset($_GET['page']) && !empty($_GET['page'])) {
        $currentPage = (int)strip_tags($_GET['page']);
      } else {
        $currentPage = 1;
      }
    }
    $this->twig->display(
      'admin/pages/comments/index.html.twig',
      [
        'comments' => (new CommentManager())->findAllComments(self::PER_PAGE, $currentPage),
        'totalPages' => ceil((new CommentManager())->countComments() / self::PER_PAGE),
        "currentPage" => $currentPage
      ]
    );
  }

  /**
   * active or deactive comment
   *
   * @param  mixed $id
   * @return void
   */
  public function switchStatus()
  {
    if ($this->isAdmin()) {
      $comment = (new CommentManager())->findOneComment($this->params['id']);
      $status = $comment->getStatus();
      if ($status === "1") {
        $status = "0";
      } else {
        $status = "1";
      }
      (new CommentManager())->updateComment($this->params['id'], $status);
    }
    $this->manageComments();
  }

  public function adminDeleteComment()
  {
    if ($this->isAdmin()) {
      (new CommentManager())->deleteComment($this->params['id']);
    }
    $this->manageComments();
  }

  public function manageSocials()
  {
    $this->twig->display(
      'admin/pages/socials/index.html.twig',
      [
        'socials' => (new SocialManager())->findAllSocials()
      ]
    );
  }

  public function adminCreateSocial()
  {
    if (!empty($_POST)) {
      $errors = (new SocialCRUD())->addSocial();
      if (empty($errors)) {
        header("Location: /admin/socials");
      }
    }

    $this->twig->display(
      'admin/pages/socials/create.html.twig',
      [
        'errors' => $errors ?? []
      ]
    );
  }

  public function adminDeleteSocial()
  {
    if ($this->isAdmin()) {
      (new SocialManager())->deleteSocial($this->params['id']);
    }
    $this->manageSocials();
  }
}
