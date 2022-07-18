<?php

namespace App\Service;

class FlashMessage
{
  const FLASH = 'FLASH_MESSAGES';
  const FLASH_ERROR = 'error';
  const FLASH_WARNING = 'warning';
  const FLASH_INFO = 'info';
  const FLASH_SUCCESS = 'success';

  /**
  * Create a flash message 
  * 
  * @param string $name
  * @param string $message
  * @param string $type
  * @return void
  */
  function create_flash_message(string $name, string $message, string $type): void
  {
      // remove existing message with the name
      if (isset($_SESSION[self::FLASH][$name])) {
          unset($_SESSION[self::FLASH][$name]);
      }
      // add the message to the session
      $_SESSION[self::FLASH][$name] = ['message' => $message, 'type' => $type];
  }

  /**
   * Format a flash message
   *
   * @param array $flash_message
   * @return string
   */
  function format_flash_message(array $flash_message): string
  {
      return sprintf('<div class="alert alert-%s">%s</div>',
          $flash_message['type'],
          $flash_message['message']
      );
  }

  /**
  * Display a flash message
  *
  * @param string $name
  * @return void
  */
  function display_flash_message(string $name): void
  {
      if (!isset($_SESSION[self::FLASH][$name])) {
          return;
      }

      // get message from the session
      $flash_message = $_SESSION[self::FLASH][$name];

      // delete the flash message
      unset($_SESSION[self::FLASH][$name]);

      // display the flash message
      echo $this->format_flash_message($flash_message);
  }

  /**
  * Display all flash messages
  *
  * @return void
  */
  function display_all_flash_messages(): void
  {
      if (!isset($_SESSION[self::FLASH])) {
          return;
      }

      // get flash messages
      $flash_messages = $_SESSION[self::FLASH];

      // remove all the flash messages
      unset($_SESSION[self::FLASH]);

      // show all flash messages
      foreach ($flash_messages as $flash_message) {
          echo $this->format_flash_message($flash_message);
      }
  }

  /**
  * Flash a message
  *
  * @param string $name
  * @param string $message
  * @param string $type (error, warning, info, success)
  * @return void
  */
  function flash(string $name = '', string $message = '', string $type = ''): void
  {
      if ($name !== '' && $message !== '' && $type !== '') {
          $this->create_flash_message($name, $message, $type);
      } elseif ($name !== '' && $message === '' && $type === '') {
          $this->display_flash_message($name);
      } elseif ($name === '' && $message === '' && $type === '') {
          $this->display_all_flash_messages();
      }
  }
}