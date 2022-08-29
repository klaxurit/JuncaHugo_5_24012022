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

  public function updateCv($adminDatas){
    $validate = new ValidationForm();
    if (!$validate->errors) {
      (new AdminManager())->updateAdminCv($adminDatas);
    }
    return $validate->errors;
  }

  public function updateAvatar($adminDatas){
    $validate = new ValidationForm();
    if (!$validate->errors) {
      (new AdminManager())->updateAdminAvatar($adminDatas);
    }
    return $validate->errors;
  }
}

