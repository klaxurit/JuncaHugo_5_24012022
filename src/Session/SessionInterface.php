<?php

namespace App\Session;

interface SessionInterface
{

  /**
   * get information in session
   *
   * @param  string $key
   * @param  mixed $default
   * @return mixed
   */
  public function get(string $key, $default);

  /**
   * set information in session
   *
   * @param  string $key
   * @param  mixed $value
   * @return void
   */
  public function set(string $key, $value): void;

  /**
   * delete a key in session
   *
   * @param  mixed $key
   */
  public function delete(string $key): void;
}
