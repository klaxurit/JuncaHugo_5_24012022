<?php

namespace App\Session;

use App\Session\SessionInterface;

class PHPSession implements SessionInterface
{
  /**
   * @param  mixed $key
   * @param  mixed $default
   * @return void
   */
  public function get(string $key, $default = null)
  {
    if (array_key_exists($key, $_SESSION)) {
      return $_SESSION[$key];
    }
    return $default;
  }

  /**
   * @param  mixed $key
   * @param  mixed $value
   * @return void
   */
  public function set(string $key, $value): void
  {
    $_SESSION[$key] = $value;
  }

  /**
   * @param  mixed $key
   * @return void
   */
  public function delete(string $key): void
  {
    unset($_SESSION[$key]);
  }
}
