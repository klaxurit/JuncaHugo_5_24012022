<?php

namespace App\Exceptions;

use Exception;

class WrongFileTypeException extends Exception 
{
  protected $message = "Type de fichier erroné.";
}
