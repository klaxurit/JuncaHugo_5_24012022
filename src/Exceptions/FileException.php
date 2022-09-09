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
  public static function wrongFileTypeException()
  {
    return new static("Type de fichier erroné.");
  }
  
  /**
   * WrongFileSizeException
   *
   * @return void
   */
  public static function wrongFileSizeException()
  {
    return new static("Fichier trop lourd, 1Mo maximum.");
  }
  
  /**
   * DownloadFileFailedException
   *
   * @return void
   */
  public static function downloadFileFailedException()
  {
    return new static("Le fichier n'a pas été téléchargé correctement.");
  }
  
  /**
   * MaxSizeException
   *
   * @return void
   */
  public static function maxSizeException()
  {
    return new static("Taille de fichier imposé par php.ini dépassé.");
  }
}
