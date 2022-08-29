<?php

namespace App\Managers;

use PDO;
use App\Model\User;
use App\Core\Manager;
use App\Model\Comment;

class CommentManager extends Manager
{
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Create a comment
   *
   * @param  mixed $postId
   * @param  mixed $comment
   * @return void
   */
  public function createComment($postId, $comment)
  {
    $comment = new Comment($comment);
    $comment->setAuthor($this->session->get("user"));

    $sql = "INSERT INTO `comment`(`content`, `user_id`, `post_id`) VALUES (:content, :userId, :postId)";

    $req = $this->pdo->prepare($sql);
    $req->bindValue(':content', $comment->getContent(), PDO::PARAM_STR);
    $req->bindValue(':userId', $comment->getAuthor()->getId(), PDO::PARAM_STR);
    $req->bindValue(':postId', $postId, PDO::PARAM_STR);
    $req->execute();

    $id = $this->pdo->lastInsertId();

    $sql = "SELECT * FROM comment WHERE id = :id";
    $req = $this->pdo->prepare($sql);
    $req->bindParam(':id', $id, PDO::PARAM_STR);
    $req->execute();

    return $comment;
  }

  /**
   * Update a comment
   *
   * @param  mixed $id
   * @param  mixed $status
   * @return void
   */
  public function updateComment(int $id, int $status)
  {
    $sql = "UPDATE comment SET status=:status WHERE id=:id";
    $req = $this->pdo->prepare($sql);
    $req->bindParam(':status', $status, PDO::PARAM_STR);
    $req->bindParam(':id', $id, PDO::PARAM_STR);
    $req->execute();
  }

  /**
   * Delete a comment
   *
   * @param  mixed $id
   * @return void
   */
  public function deleteComment(int $id)
  {
    $sql = "DELETE FROM comment WHERE id=:id";
    $req = $this->pdo->prepare($sql);
    $req->bindParam(':id', $id, PDO::PARAM_STR);
    $req->execute();
  }

  /**
   * Count all comments
   *
   * @return void
   */
  public function countComments()
  {
    // Count the total of comments
    $sql2 = "SELECT COUNT(*) AS total_comments from `comment`;";
    $req = $this->pdo->prepare($sql2);
    $req->execute();
    $result = $req->fetch();
    $totalComments = (int) $result['total_comments'];
    return $totalComments;
  }

  /**
   * Find all comments
   *
   * @param  mixed $limit
   * @param  mixed $first_comment
   * @return void
   */
  public function findAllComments($limit, $first_comment)
  {
    // Calcul the first comment of the page
    $offset = ($first_comment * $limit) - $limit;

    // Find all comments
    $sql = "SELECT * FROM comment
    LIMIT :per_page
    OFFSET :first_comment;
    ";
    $req = $this->pdo->prepare($sql);
    $req->bindParam(':first_comment', $offset, PDO::PARAM_INT);
    $req->bindParam(':per_page', $limit, PDO::PARAM_INT);
    $req->execute();

    $datas = $req->fetchAll();
    $comments = [];

    foreach ($datas as $data) {
      $comment = new Comment($data);

      array_push($comments, $comment);
    }

    return $comments;
  }

  /**
   * Find one comment by id
   *
   * @param  mixed $id
   * @return void
   */
  public function findOneComment(int $id)
  {
    $sql = "SELECT * FROM comment WHERE id = :id";
    $req = $this->pdo->prepare($sql);
    $req->bindParam(':id', $id, PDO::PARAM_STR);
    $req->execute();

    $data = $req->fetch();

    $comment = new Comment($data);

    return $comment;
  }

  /**
   * Get comment by post id
   *
   * @param  mixed $id
   * @return void
   */
  public function getCommentsByPostId(int $id)
  {
    $sql = "SELECT c.*, u.username,
    c.id as comment_id, u.id as user_id
    FROM comment as c
    INNER JOIN user as u ON u.id = c.user_id
    WHERE post_id = :id";

    $req = $this->pdo->prepare($sql);
    $req->bindParam(':id', $id);
    $req->execute();
    $datas = $req->fetchAll();
    $comments = [];

    foreach ($datas as $data) {
      $data['id'] = $data['comment_id'];
      $comment = new Comment($data);

      $data['id'] = $data['user_id'];
      $author = new User($data);

      $comment->setAuthor($author);
      array_push($comments, $comment);
    }

    return $comments;
  }
}
