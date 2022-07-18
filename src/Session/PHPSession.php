<?php

namespace App\Session;

use App\Session\SessionInterface;

class PHPSession implements SessionInterface
{

  /**
   * ensure that the session is Started
   *
   * @return void
   */
  private function ensureStarted()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
  }

  /**
   * @param  mixed $key
   * @param  mixed $default
   * @return void
   */
  public function get(string $key, $default = null)
  {
    $this->ensureStarted();
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
    $this->ensureStarted();
    $_SESSION[$key] = $value;
  }

  /**
   * @param  mixed $key
   * @return void
   */
  public function delete(string $key): void
  {
    $this->ensureStarted();
    unset($_SESSION[$key]);
  }
}
