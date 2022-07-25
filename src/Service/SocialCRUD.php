<?php

namespace App\Service;

use App\Service\ValidationForm;
use App\Managers\SocialManager;
use App\Model\Social;

class SocialCRUD
{
  public function addSocial()
  {
    $validate = new ValidationForm();
    $validate->checkAddSocial($_POST);
    if (!$validate->errors) {
      (new SocialManager())->createSocial($_POST);
    }
    return $validate->errors;
  }

  public function modifySocial(int $id)
  {
    $validate = new ValidationForm();
    // Undefined index si je décommente
    // $validate->checkAddSocial($_POST);
    if (!$validate->errors) {
      (new SocialManager())->updateSocial($id);
    }
    return $validate->errors;
  }
}