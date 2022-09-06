<?php

namespace App\Exceptions;

use Exception;

class DownloadFileFailedException extends Exception 
{
  protected $message = "Le fichier n'a pas été téléchargé correctement.";
}
