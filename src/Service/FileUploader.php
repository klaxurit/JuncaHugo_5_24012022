<?php

namespace App\Service;

use App\Exceptions\FileException;

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

        // On gère les erreurs pouvant être lié a la config du php.ini
        if ($file["error"] === 1) {
            throw FileException::maxSizeException();
        }

        // On vérifie l'absence de l'extension dans les clefs $allowed ou l'absence du type mime dans les valeurs
        if (!array_key_exists($extension, $allowed) || !in_array($fileType, $allowed)) {
            // Ici soit l'extension soit le type est incorrect
            throw FileException::wrongFileTypeException();
        }

        // Ici le type est correct
        // On limite a 1Mo
        if ($fileSize > 1024 * 1024) {
            throw FileException::wrongFileSizeException();
        }

        // On génère un nom unique
        $newName = md5(uniqid());

        $relativePath = "/public/uploads/$newName.$extension";

        // On génère le chemin complet
        $filePath = ROOT_DIR . $relativePath;

        if (!move_uploaded_file($file["tmp_name"], $filePath)) {
            // déclancher une exxception et la gérer dans le controller
            throw FileException::downloadFileFailedException();
        }

        // On protège l'utiliseur d'un éventuel script
        chmod($filePath, 0644);

        $newPath = str_replace("/public/", "", $relativePath);

        return $newPath;
    }
}
