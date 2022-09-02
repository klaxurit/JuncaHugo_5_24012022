<?php

namespace App\Service;

use App\Exceptions\WrongFileTypeException;
use App\Exceptions\WrongFileSizeException;
use App\Exceptions\DownloadFileFailedException;

class FileUploader
{
    /**
     * Verify, secure and upload file
     *
     * @param  mixed $file
     * @return void
     */
    public function uploadFile($file, $type)
    {
        // On a recu le fichier
        // On procède aux vérifications
        // On vérifie toujours l'extension et le type mime
        $fileName = $file["name"];
        $fileType = $file["type"];
        $fileSize = $file["size"];

        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ($type === "image") {
            $allowed = [
                "jpg" => "image/jpeg",
                "jpeg" => "image/jpeg",
                "png" => "image/png",
                "svg" => "image/svg+xml",
            ];
        }

        if ($type === "document") {
            $allowed = [
                "pdf" => "application/pdf"
            ];
        }

        // On vérifie l'absence de l'extension dans les clefs $allowed ou l'absence du type mime dans les valeurs
        if (!array_key_exists($extension, $allowed) || !in_array($fileType, $allowed)) {
            // Ici soit l'extension soit le type est incorrect
            throw new WrongFileTypeException();
        }

        // Ici le type est correct
        // On limite a 1Mo
        if ($fileSize > 1024 * 1024) {
            throw new WrongFileSizeException();
        }

        // On génère un nom unique
        $newName = md5(uniqid());

        // On génère le chemin complet
        $filePath = ROOT_DIR . "/public/uploads/$newName.$extension";

        if (!move_uploaded_file($file["tmp_name"], $filePath)) {
            // déclancher une exxception et la gérer dans le controller
            throw new DownloadFileFailedException();
        }

        // On protège l'utiliseur d'un éventuel script
        chmod($filePath, 0644);

        return array($extension, $filePath);
    }
}
