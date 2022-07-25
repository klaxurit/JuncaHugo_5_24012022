<?php

namespace App\Managers;

use PDO;
use App\Model\Post;
use App\Model\User;
use App\Core\Manager;
use App\Model\Comment;

class PostManager extends Manager
{
  public function __construct()
  {
    parent::__construct();
  }

  public function createPost($post)
  {
    //
  }

  public function updatePost()
  {
    //
  }

  public function deletePost()
  {
    //
  }
  
  /**
   * Count all posts in db
   *
   * @return void
   */
  public function countPosts()
  {
    // Count the total of posts
    $sql2 = "SELECT COUNT(*) AS total_posts from `post`;";
    $req = $this->pdo->prepare($sql2);
    $req->execute();
    $result = $req->fetch();
    $totalPosts = (int) $result['total_posts'];
    return $totalPosts;
  }


  /**
   * Find all posts
   *
   * @return void
   */
  public function findAllPosts($limit, $first_post)
  {
    // Calcul the first post of the page
    $offset = ($first_post * $limit) - $limit;

    // Find all posts
    $sql = "SELECT *, 
    p.created_at as post_created_at, u.created_at as user_created_at, 
    p.updated_at as post_updated_at, u.updated_at as user_updated_at,
    p.id as post_id, u.id as user_id
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
      $data['id'] = $data['post_id'];
      $post = new Post($data);

      $data['createdAt'] = $data['user_created_at'];
      $data['updatedAt'] = $data['user_updated_at'];
      $data['id'] = $data['user_id'];
      $author = new User($data);

      $post->setAuthor($author);
      array_push($posts, $post);
    }


    return $posts;
  }



  /**
   * Get post by slug
   *
   * @param  mixed $slug
   * @return void
   */
  public function getPostBySlug(string $slug)
  {
    $sql = "SELECT *, 
    p.created_at as post_created_at, u.created_at as user_created_at, 
    p.updated_at as post_updated_at, u.updated_at as user_updated_at,
    p.id as post_id, u.id as user_id
    FROM post as p
    LEFT OUTER JOIN user as u
    ON p.user_id = u.id
    WHERE p.slug = :slug";

    $req = $this->pdo->prepare($sql);
    $req->bindParam(':slug', $slug);
    $req->execute();
    $data = $req->fetch();

    $data['createdAt'] = $data['post_created_at'];
    $data['updatedAt'] = $data['post_updated_at'];
    $data['id'] = $data['post_id'];
    $post = new Post($data);

    $data['createdAt'] = $data['user_created_at'];
    $data['updatedAt'] = $data['user_updated_at'];
    $data['id'] = $data['user_id'];
    $author = new User($data);

    // Add Author by associating user and post
    $post->setAuthor($author);

    return $post;
  }
}
