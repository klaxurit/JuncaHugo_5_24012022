<?php

namespace App\Session;

use App\Session\SessionInterface;

class ArraySession implements SessionInterface
{

  private $session;

  /**
   * get
   *
   * @param  mixed $key
   * @param  mixed $default
   * @return void
   */
  public function get(string $key, $default = null)
  {
    if (array_key_exists($key, $this->session)) {
      return $this->session[$key];
    }
    return $default;
  }

  /**
   * set
   *
   * @param  mixed $key
   * @param  mixed $value
   * @return void
   */
  public function set(string $key, $value): void
  {
    $this->session[$key] = $value;
  }

  /**
   * delete
   *
   * @param  mixed $key
   * @return void
   */
  public function delete(string $key): void
  {
    unset($this->session[$key]);
  }
}
