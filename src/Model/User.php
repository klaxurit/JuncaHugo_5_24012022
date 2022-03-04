<?php

namespace App\Model;

use Entity;

class User extends Entity
{
  private string $firstname;
  private string $lastname;
  private string $username;
  private string $email;
  private string $password;

  /**
   * @return string
   */
  public function getFirstname()
  {
    return $this->firstname;
  }

  /**
   * @param string $firstname
   */
  public function setFirstname($firstname)
  {
    $this->firstname = $firstname;
  }

  /**
   * @return string
   */
  public function getLastname()
  {
    return $this->lastname;
  }

  /**
   * @param string $lastname
   */
  public function setLastname($lastname)
  {
    $this->lastname = $lastname;
  }

  /**
   * @return string
   */
  public function getUsername()
  {
    return $this->username;
  }

  /**
   * @param string $username
   */
  public function setUsername($username)
  {
    $this->username = $username;
  }
}
