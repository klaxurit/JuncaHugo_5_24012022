<?php

namespace App\Model;

use App\Model\User;

class Admin extends User
{
  private string $description;
  private string $tagline;
  private string $avatarUrl;
  private string $avatarAlt;
  private string $cvUrl;

  

  /**
   * Get the value of description
   *
   * @return  string
   */
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * Set the value of description
   *
   * @param  string  $description
   *
   * @return  self
   */
  public function setDescription(string $description)
  {
    $this->description = $description;

    return $this;
  }

  /**
   * Get the value of tagline
   *
   * @return  string
   */
  public function getTagline()
  {
    return $this->tagline;
  }

  /**
   * Set the value of tagline
   *
   * @param  string  $tagline
   *
   * @return  self
   */
  public function setTagline(string $tagline)
  {
    $this->tagline = $tagline;

    return $this;
  }

  /**
   * Get the value of avatarUrl
   *
   * @return  string
   */
  public function getAvatarUrl()
  {
    return $this->avatarUrl;
  }

  /**
   * Set the value of avatarUrl
   *
   * @param  string  $avatarUrl
   *
   * @return  self
   */
  public function setAvatarUrl(string $avatarUrl)
  {
    $this->avatarUrl = $avatarUrl;

    return $this;
  }

  /**
   * Get the value of avatarAlt
   *
   * @return  string
   */
  public function getAvatarAlt()
  {
    return $this->avatarAlt;
  }

  /**
   * Set the value of avatarAlt
   *
   * @param  string  $avatarAlt
   *
   * @return  self
   */
  public function setAvatarAlt(string $avatarAlt)
  {
    $this->avatarAlt = $avatarAlt;

    return $this;
  }

  /**
   * Get the value of cvUrl
   *
   * @return  string
   */
  public function getCvUrl()
  {
    return $this->cvUrl;
  }

  /**
   * Set the value of cvUrl
   *
   * @param  string  $cvUrl
   *
   * @return  self
   */
  public function setCvUrl(string $cvUrl)
  {
    $this->cvUrl = $cvUrl;

    return $this;
  }
}