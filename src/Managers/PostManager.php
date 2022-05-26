<?php

namespace App\Managers;

use PDO;
use App\Model\Post;
use App\Model\User;
use App\Core\Manager;
use App\Service\PaginationService;

class PostManager extends Manager
{
  public function __construct()
  {
    parent::__construct();
    $this->paginate = new PaginationService();
  }


  /**
   * find all posts in db
   *
   * @return void
   */
  public function findAllPosts()
  {
    // determinate what is the current page
    if (isset($_GET['page']) && !empty($_GET['page'])) {
      $currentPage = (int) strip_tags($_GET['page']);
    } else {
      $currentPage = 1;
    }

    // count the total of posts
    $sql2 = "SELECT COUNT(*) AS total_posts from `post`;";
    $req = $this->pdo->prepare($sql2);
    $req->execute();
    $result = $req->fetch();
    $totalPosts = (int) $result['total_posts'];

    // determinate the number of post per page
    $perPage = 4;

    // calcul the total of pages
    $pages = ceil($totalPosts / $perPage);

    // calcul the first post of the page
    $firstPost = ($currentPage * $perPage) - $perPage;


    var_dump($pages, "Number of pages", $perPage, "Number of posts per pages");

    // find all posts
    $sql = "SELECT *, 
    p.created_at as post_created_at, u.created_at as user_created_at, 
    p.updated_at as post_updated_at, u.updated_at as user_updated_at
    FROM post as p
    LEFT OUTER JOIN user as u
    ON p.user_id = u.id
    LIMIT :first_post, :per_page;
    ";
    $req = $this->pdo->prepare($sql);
    $req->bindParam(':first_post', $firstPost, PDO::PARAM_INT);
    $req->bindParam(':per_page', $perPage, PDO::PARAM_INT);
    $req->execute();
    $datas = $req->fetchAll();

    var_dump($firstPost, "First post", $perPage, "Number of posts per pages");

    $posts = [];

    foreach ($datas as $data) {
      $data['createdAt'] = $data['post_created_at'];
      $data['updatedAt'] = $data['post_updated_at'];
      $post = new Post($data);

      $data['createdAt'] = $data['user_created_at'];
      $data['updatedAt'] = $data['user_updated_at'];
      $author = new User($data);

      $post->setAuthor($author);
      array_push($posts, $post);
    }

    return $posts;
  }


  /**
   * find one post by slug
   *
   * @param  mixed $slug
   * @return void
   */
  public function getPostBySlug(string $slug)
  {
    // using slug to find the post
    $sql = "SELECT *, 
    p.created_at as post_created_at, u.created_at as user_created_at, 
    p.updated_at as post_updated_at, u.updated_at as user_updated_at
    FROM post as p
    LEFT OUTER JOIN user as u
    ON p.user_id = u.id WHERE p.slug = :slug
    ";

    $req = $this->pdo->prepare($sql);
    $req->bindParam(':slug', $slug);
    $req->execute();
    $datas = $req->fetch();


    $datas['createdAt'] = $datas['post_created_at'];
    $datas['updatedAt'] = $datas['post_updated_at'];
    $post = new Post($datas);

    $datas['createdAt'] = $datas['user_created_at'];
    $datas['updatedAt'] = $datas['user_updated_at'];
    $author = new User($datas);
    $post->setAuthor($author);

    return $post;
  }
}
