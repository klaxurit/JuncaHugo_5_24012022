<?php

namespace App\Core;

use DateTime;

class Entity
{
  private int $id;
  private DateTime $createdAt;
  private DateTime $updatedAt;

  public function __construct(array $data=[]) {
    if(!empty($data)) {
      $this->hydrate($data);
    }
  }
  
  /**
   * hydrate each element in data table with $method
   *
   * @return void
   */
  public function hydrate(array $data=[]) {
    foreach ($data as $key => $value) {
			$method = "set". str_replace("_", "", ucwords($key, "_"));

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
}
