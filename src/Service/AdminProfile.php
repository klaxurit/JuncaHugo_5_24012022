<?php

namespace App\Service;

use App\Managers\AdminManager;

class AdminProfile
{
  public function updateInfos(int $id){
    $validate = new ValidationForm();
    if (!$validate->errors) {
      (new AdminManager())->updateAdmin($id);
    }
    return $validate->errors;
  }
}