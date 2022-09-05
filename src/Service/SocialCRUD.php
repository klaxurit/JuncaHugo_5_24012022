<?php

namespace App\Service;

use App\Service\ValidationForm;
use App\Managers\SocialManager;
use App\Model\Social;

class SocialCRUD
{

  /**
   * Check errors and send data to manager
   *
   * @param  mixed $socialDatas
   * @return void
   */
  public function addSocial($socialDatas)
  {
    $validate = new ValidationForm();
    $validate->checkAddSocial($socialDatas);
    if (!$validate->errors) {
      (new SocialManager())->createSocial($socialDatas);
    }
    return $validate->errors;
  }

  /**
   * Check errors and send data to manager
   *
   * @param  mixed $socialDatas
   * @return void
   */
  public function modifySocial($socialDatas)
  {
    $validate = new ValidationForm();
    $validate->checkUpdateSocial($socialDatas);
    if (!$validate->errors) {
      (new SocialManager())->updateSocial($socialDatas);
    }
    return $validate->errors;
  }
}
