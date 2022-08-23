<?php

namespace App\Service;

use App\Service\ValidationForm;
use App\Managers\SocialManager;
use App\Model\Social;

class SocialCRUD
{
  public function addSocial($socialDatas)
  {
    $validate = new ValidationForm();
    $validate->checkAddSocial($socialDatas);
    if (!$validate->errors) {
      (new SocialManager())->createSocial($socialDatas);
    }
    return $validate->errors;
  }

  public function modifySocial($socialDatas)
  {
    $validate = new ValidationForm();
    // Undefined index si je décommente
    // $validate->checkAddSocial($_POST);
    if (!$validate->errors) {
      (new SocialManager())->updateSocial($socialDatas);
    }
    return $validate->errors;
  }
}