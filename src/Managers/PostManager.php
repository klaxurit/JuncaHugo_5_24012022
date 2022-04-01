<?php

namespace App\Managers;

use PDO;
use App\Model\Post;
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

    $sql = "SELECT * FROM post INNER JOIN user ON post.user_id = user.id";
    $req = $this->pdo->prepare($sql);
    $req->execute();
    $datas = $req->fetchAll();
    echo '<pre>';
    var_dump($datas);
    echo "</pre>";

    $posts = [];



    foreach ($datas as $data) {
      $post = new Post($data);
      array_push($posts, $post);
    }

    // echo '<pre>';
    // var_dump($posts);
    // echo "</pre>";
    return $posts;
  }
}
