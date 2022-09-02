<?php

namespace App\Exceptions;

use Exception;

class WrongFileSizeException extends Exception 
{
  protected $message = "Fichier trop lourd, 1Mo maximum.";
}