<?php

namespace App\Service;

use App\Managers\AdminManager;

class AdminProfile
{
  public function updateInfos(int $id, int $userId){
    $validate = new ValidationForm();
    if (!$validate->errors) {
      (new AdminManager())->updateAdminInfos($id, $userId);
    }
    return $validate->errors;
  }
}