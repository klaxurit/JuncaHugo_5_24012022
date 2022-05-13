<?php

namespace App\Model;

use App\Model\User;
use App\Core\Entity;

class Post extends Entity
{
  private $title;
  private $caption;
  private $content;
  private $user_id;
  private $cover_image;
  private $alt_cover_image;
  private $slug;
  private User $author;



  /**
   * Get the value of title
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * Set the value of title
   *
   * @return  self
   */
  public function setTitle($title)
  {
    $this->title = $title;

    return $this;
  }

  /**
   * Get the value of caption
   */
  public function getCaption()
  {
    return $this->caption;
  }

  /**
   * Set the value of caption
   *
   * @return  self
   */
  public function setCaption($caption)
  {
    $this->caption = $caption;

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
   * Get the value of cover_image
   */
  public function getCoverImage()
  {
    return $this->cover_image;
  }

  /**
   * Set the value of cover_image
   *
   * @return  self
   */
  public function setCoverImage($cover_image)
  {
    $this->cover_image = $cover_image;

    return $this;
  }

  /**
   * Get the value of alt_cover_image
   */
  public function getAltCoverImage()
  {
    return $this->alt_cover_image;
  }

  /**
   * Set the value of alt_cover_image
   *
   * @return  self
   */
  public function setAltCoverImage($alt_cover_image)
  {
    $this->alt_cover_image = $alt_cover_image;

    return $this;
  }

  /**
   * Get the value of slug
   */
  public function getSlug()
  {
    return $this->slug;
  }

  /**
   * Set the value of slug
   *
   * @return  self
   */
  public function setSlug($slug)
  {
    $this->slug = $slug;

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
