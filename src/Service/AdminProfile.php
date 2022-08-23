<?php

namespace App\Service;

use App\Managers\AdminManager;
use App\Service\FileUploader;

class AdminProfile
{
  public function updateInfos($adminDatas){
    $validate = new ValidationForm();
    if (!$validate->errors) {
      (new AdminManager())->updateAdminInfos($adminDatas);
    }
    return $validate->errors;
  }

  public function updateFiles($adminDatas){
    var_dump($adminDatas, "ici");
    die();
    $validate = new ValidationForm();
    if (!$validate->errors) {
      (new AdminManager())->updateAdminFiles($adminDatas);
    }
    return $validate->errors;
  }
}