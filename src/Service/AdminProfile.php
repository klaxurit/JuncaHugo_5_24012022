<?php

namespace App\Service;

use App\Managers\AdminManager;

class AdminProfile
{
  public function updateInfos($adminDatas){
    $validate = new ValidationForm();
    if (!$validate->errors) {
      (new AdminManager())->updateAdminInfos($adminDatas);
    }
    return $validate->errors;
  }
}