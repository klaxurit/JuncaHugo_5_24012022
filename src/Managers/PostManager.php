<?php

namespace App\Managers;

use PDO;
use App\Model\Post;
use App\Model\User;
use App\Core\Manager;

class PostManager extends Manager
{
  public function __construct()
  {
    parent::__construct();
  }


  /**
   * find all posts in db
   *
   * @return void
   */
  public function findPost()
  {

    $sql = "SELECT *, 
    p.created_at as post_created_at, u.created_at as user_created_at, 
    p.updated_at as post_updated_at, u.updated_at as user_updated_at
    FROM post as p
    LEFT OUTER JOIN user as u
    ON p.user_id = u.id
    ";
    $req = $this->pdo->prepare($sql);
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
}
