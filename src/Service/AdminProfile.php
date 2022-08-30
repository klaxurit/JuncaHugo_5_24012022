<?php

namespace App\Service;

use App\Managers\AdminManager;
use App\Service\FileUploader;

class AdminProfile
{  
  /**
   * Check errors and send data to manager
   *
   * @param  mixed $adminDatas
   * @return void
   */
  public function updateInfos($adminDatas){
    $validate = new ValidationForm();
    if (!$validate->errors) {
      (new AdminManager())->updateAdminInfos($adminDatas);
    }
    return $validate->errors;
  }
  
  /**
   * Check errors and send data to manager
   *
   * @param  mixed $adminDatas
   * @return void
   */
  public function updateCv($adminDatas){
    $validate = new ValidationForm();
    if (!$validate->errors) {
      (new AdminManager())->updateAdminCv($adminDatas);
    }
    return $validate->errors;
  }
  
  /**
   * Check errors and send data to manager
   *
   * @param  mixed $adminDatas
   * @return void
   */
  public function updateAvatar($adminDatas){
    $validate = new ValidationForm();
    if (!$validate->errors) {
      (new AdminManager())->updateAdminAvatar($adminDatas);
    }
    return $validate->errors;
  }
}

