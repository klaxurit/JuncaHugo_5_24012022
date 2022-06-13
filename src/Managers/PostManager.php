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

  public function countPosts()
  {
    // count the total of posts
    $sql2 = "SELECT COUNT(*) AS total_posts from `post`;";
    $req = $this->pdo->prepare($sql2);
    $req->execute();
    $result = $req->fetch();
    $totalPosts = (int) $result['total_posts'];
    return $totalPosts;
  }


  /**
   * find all posts in db
   *
   * @return void
   */
  public function findAllPosts($limit, $first_post)
  {
    // calcul the first post of the page
    $offset = ($first_post * $limit) - $limit;

    // find all posts
    $sql = "SELECT *, 
    p.created_at as post_created_at, u.created_at as user_created_at, 
    p.updated_at as post_updated_at, u.updated_at as user_updated_at
    FROM post as p
    LEFT OUTER JOIN user as u
    ON p.user_id = u.id
    LIMIT :per_page
    OFFSET :first_post;
    ";
    $req = $this->pdo->prepare($sql);
    $req->bindParam(':first_post', $offset, PDO::PARAM_INT);
    $req->bindParam(':per_page', $limit, PDO::PARAM_INT);
    $req->execute();
    $datas = $req->fetchAll();


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
