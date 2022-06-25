<?php

namespace App\Controllers;

use App\Model\Comment;
use App\Core\Controller;
use App\Managers\PostManager;
use App\Managers\AdminManager;
use App\Managers\CommentManager;

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
  private function isAdmin()
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
  // public function activateComment(int $id)
  // {
  //   if ($this->isAdmin()) {
  //     $comment = (new CommentManager())->getCommentsByPostId($id);
  //     die(var_dump($comment));
  //     $comment = new Comment();
  //     $comment->setStatus($comment->getStatus() ? 0 : 1);
  //   }
  //   $comment->updateComment();
  // }
}
