<?php 

namespace App\Service;

class FileUploader
{
  public function uploadFile()
  {
    if(isset($_FILES["monfichier"]) && $_FILES["monfichier"]["error"] === 0) {
      // On a recu le fichier
      // On procède aux vérifications
      // On vérifie toujours l'extension et le type mime
      $allowed = [
        "jpg" => "image/jpeg",
        "jpeg" => "image/jpeg",
        "png" => "image/png",
        "pdf" => "application/pdf"
      ];

      $fileName = $_FILES["monfichier"]["name"];
      $fileType = $_FILES["monfichier"]["type"];
      $fileSize = $_FILES["monfichier"]["size"];

      $extension = pathinfo($fileName, PATHINFO_EXTENSION);
      // On vérifie l'absence de l'etension dans les clefs $allowed ou l'bsence du type mime dans les valeurs
      if(!array_key_exists($extension, $allowed) || !in_array($fileType, $allowed)) {
        // Ici soit l'extension soit le type est incorrect
        die("Erreur: format de fichier incorrect");
      }
    }
  }
}
