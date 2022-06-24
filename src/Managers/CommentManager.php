<?php

namespace App\Managers;

use PDO;
use App\Core\Manager;

class CommentManager extends Manager
{
  public function __construct()
  {
    parent::__construct();
  }

  public function createComment()
  {
    //
  }

  public function updateComment(int $id)
  {
    //
  }

  public function deleteComment(int $id)
  {
    //
  }

  public function countComments()
  {
    // count the total of comments
    $sql2 = "SELECT COUNT(*) AS total_comments from `comment`;";
    $req = $this->pdo->prepare($sql2);
    $req->execute();
    $result = $req->fetch();
    $totalComments = (int) $result['total_comments'];
    return $totalComments;
  }

  public function findAllComments($limit, $first_comment)
  {
    // calcul the first post of the page
    $offset = ($first_comment * $limit) - $limit;

    // find all posts
    $sql = "SELECT * FROM comment
    LIMIT :per_page
    OFFSET :first_comment;
    ";
    $req = $this->pdo->prepare($sql);
    $req->bindParam(':first_comment', $offset, PDO::PARAM_INT);
    $req->bindParam(':per_page', $limit, PDO::PARAM_INT);
    $req->execute();

    return $req->fetchAll();
  }

  public function getCommentsByPostId(int $id)
  {
    $sql = "SELECT c.*, u.username
    FROM comment as c
    INNER JOIN user as u ON u.id = c.user_id
    WHERE post_id = :id";

    $req = $this->pdo->prepare($sql);
    $req->bindParam(':id', $id);
    $req->execute();

    return $req->fetchAll();
  }
}
