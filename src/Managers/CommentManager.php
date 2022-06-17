<?php

namespace App\Managers;

use PDO;
use App\Model\Comment;
use App\Model\Post;
use App\Model\User;
use App\Core\Manager;

class CommentManager extends Manager
{
  public function __construct()
  {
    parent::__construct();
  }

  public function findAll()
  {
    $sql = "SELECT * FROM comment";
    $req = $this->pdo->prepare($sql);
    $req->execute();
    $datas = $req->fetchAll();
  }

  public function getCommentByPostId()
  {
    $sql = "SELECT * FROM comment WHERE id = :id";
    $req = $this->pdo->prepare($sql);
    $req->bindParam(':id', $id);
    $req->execute();
    $datas = $req->fetchAll();

    $comments = [];

    foreach ($datas as $comments) {
      array_push($comments, new Comment());
    }

    return $comments;
  }
}
