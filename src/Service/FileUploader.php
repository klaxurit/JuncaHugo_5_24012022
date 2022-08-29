<?php 

namespace App\Service;

class FileUploader
{
  public function uploadFile($file)
  {
                var_dump($file);
            die();
    if(isset($_FILES["monfichier"]) && $_FILES["monfichier"]["error"] === 0) {
      // On a recu le fichier
      // On procède aux vérifications
      // On vérifie toujours l'extension et le type mime
      $fileName = $_FILES["monfichier"]["name"];
      $fileType = $_FILES["monfichier"]["type"];
      $fileSize = $_FILES["monfichier"]["size"];
      $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

      // Tableau des extension / type mime accepté
      $allowed = [
          "jpg" => "image/jpeg",
          "jpeg" => "image/jpeg",
          "png" => "image/png",
          "svg" => "image/svg+xml",
          "pdf" => "application/pdf"
      ];
      
      // On vérifie l'absence de l'extension dans les clefs $allowed ou l'absence du type mime dans les valeurs
      if(!array_key_exists($extension, $allowed) || !in_array($fileType, $allowed)) {
          // Ici soit l'extension soit le type est incorrect
          $this->flash->set('Type de fichier non pris en compte.', 'error');
          return header("Location: /admin");
      }

      // Ici le type est correct
      // On limite a 1Mo
      if($fileSize > 1024 * 1024) {
          $this->flash->set('Fichier trop volumineux.', 'error');
          return header("Location: /admin");
      }

      // On génère un nom unique
      $newName = md5(uniqid());

      // On génère le chemin complet
      $filePath = ROOT_DIR . "/public/uploads/$newName.$extension";

      if(!move_uploaded_file($_FILES["monfichier"]["tmp_name"], $filePath)) {
          $this->flash->set('Le téléchargement du fichier a échoué.', 'error');
          return header("Location: /admin");
      }

      // On protège l'utiliseur d'un éventuel script
      chmod($filePath, 0644);

      if ($extension === "jpg" || $extension === "jpeg" || $extension === "png" || $extension === "svg") {
          $adminDatas->setAvatarUrl("$newName.$extension");
      } else {
          $adminDatas->setCvUrl("$newName.$extension");
      }

      $errors = (new AdminProfile())->updateFiles($adminDatas);
    }
  }
}
