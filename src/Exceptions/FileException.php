<?php

namespace App\Exceptions;

use Exception;

class FileException extends Exception
{  
  /**
   * WrongFileTypeException
   *
   * @return void
   */
  public static function WrongFileTypeException()
  {
    return new static("Type de fichier erroné.");
  }
  
  /**
   * WrongFileSizeException
   *
   * @return void
   */
  public static function WrongFileSizeException()
  {
    return new static("Fichier trop lourd, 1Mo maximum.");
  }
  
  /**
   * DownloadFileFailedException
   *
   * @return void
   */
  public static function DownloadFileFailedException()
  {
    return new static("Le fichier n'a pas été téléchargé correctement.");
  }
  
  /**
   * MaxSizeException
   *
   * @return void
   */
  public static function MaxSizeException()
  {
    return new static("Taille de fichier imposé par php.ini dépassé.");
  }
}