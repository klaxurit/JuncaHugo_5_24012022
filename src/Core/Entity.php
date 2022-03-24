<?php

namespace App\Core;

use DateTime;

class Entity
{
  private int $id;
  private DateTime $createdAt;
  private DateTime $updatedAt;

  public function __construct(array $data = [])
  {
    if (!empty($data)) {
      $this->hydrate($data);
    }
  }

  /**
   * hydrate each element in data table with $method
   *
   * @return void
   */
  public function hydrate(array $data = [])
  {
    foreach ($data as $key => $value) {
      $method = "set" . str_replace("_", "", ucwords($key, "_"));

      if (is_callable([$this, $method])) {
        $this->$method($value);
      }
    }
  }

  /**
   * getId
   *
   * @return void
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * setId
   *
   * @param  mixed $id
   * @return void
   */
  public function setId(int $id)
  {
    $this->id = $id;
  }

  /**
   * Get the value of createdAt
   *
   * @return  DateTime
   */
  public function getCreatedAt()
  {
    return $this->createdAt;
  }

  /**
   * Set the value of createdAt
   *
   * @param  DateTime  $createdAt
   *
   * @return  self
   */
  public function setCreatedAt(DateTime $createdAt)
  {
    $this->createdAt = $createdAt;

    return $this;
  }

  /**
   * Get the value of updatedAt
   *
   * @return  DateTime
   */
  public function getUpdatedAt()
  {
    return $this->updatedAt;
  }

  /**
   * Set the value of updatedAt
   *
   * @param  DateTime  $updatedAt
   *
   * @return  self
   */
  public function setUpdatedAt(DateTime $updatedAt)
  {
    $this->updatedAt = $updatedAt;

    return $this;
  }
}
