<?php

namespace App\Managers;

use App\Core\Manager;

class CommentManager extends Manager
{
  public function __construct()
  {
    parent::__construct();
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
