<?php

namespace App\Model;

use App\Core\Entity;

class User extends Entity
{
  private string $firstname;
  private string $lastname;
  private string $username;
  private string $email;
  private string $password;



  /**
   * Get the value of firstname
   *
   * @return  string
   */
  public function getFirstname()
  {
    return $this->firstname;
  }

  /**
   * Set the value of firstname
   *
   * @param  string  $firstname
   *
   * @return  self
   */
  public function setFirstname(string $firstname)
  {
    $this->firstname = $firstname;

    return $this;
  }

  /**
   * Get the value of lastname
   *
   * @return  string
   */
  public function getLastname()
  {
    return $this->lastname;
  }

  /**
   * Set the value of lastname
   *
   * @param  string  $lastname
   *
   * @return  self
   */
  public function setLastname(string $lastname)
  {
    $this->lastname = $lastname;

    return $this;
  }

  /**
   * Get the value of username
   *
   * @return  string
   */
  public function getUsername()
  {
    return $this->username;
  }

  /**
   * Set the value of username
   *
   * @param  string  $username
   *
   * @return  self
   */
  public function setUsername(string $username)
  {
    $this->username = $username;

    return $this;
  }

  /**
   * Get the value of email
   *
   * @return  string
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Set the value of email
   *
   * @param  string  $email
   *
   * @return  self
   */
  public function setEmail(string $email)
  {
    $this->email = $email;

    return $this;
  }

  /**
   * Get the value of password
   *
   * @return  string
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Set the value of password
   *
   * @param  string  $password
   *
   * @return  self
   */
  public function setPassword(string $password)
  {
    $this->password = $password;

    return $this;
  }
}
