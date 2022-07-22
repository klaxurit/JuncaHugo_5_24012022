<?php

namespace App\Model;

use App\Core\Entity;

class Comment extends Entity
{
  private $user_id;
  private $post_id;
  private $content;
  private $status;
  private User $author;

  /**
   * Get the value of status
   */
  public function getStatus()
  {
    return $this->status;
  }

  /**
   * Set the value of status
   *
   * @return  self
   */
  public function setStatus($status)
  {
    $this->status = $status;

    return $this;
  }

  /**
   * Get the value of content
   */
  public function getContent()
  {
    return $this->content;
  }

  /**
   * Set the value of content
   *
   * @return  self
   */
  public function setContent($content)
  {
    $this->content = $content;

    return $this;
  }

  /**
   * Get the value of post_id
   */
  public function getPostId()
  {
    return $this->post_id;
  }

  /**
   * Set the value of post_id
   *
   * @return  self
   */
  public function setPostId($post_id)
  {
    $this->post_id = $post_id;

    return $this;
  }

  /**
   * Get the value of user_id
   */
  public function getUserId()
  {
    return $this->user_id;
  }

  /**
   * Set the value of user_id
   *
   * @return  self
   */
  public function setUserId($user_id)
  {
    $this->user_id = $user_id;

    return $this;
  }
  /**
   * Get the value of author
   */
  public function getAuthor(): User
  {
    return $this->author;
  }

  /**
   * Set the value of author
   */
  public function setAuthor(User $author): self
  {
    $this->author = $author;

    return $this;
  }
}
