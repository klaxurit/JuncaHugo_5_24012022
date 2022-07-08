<?php

namespace App\Service;

use App\Service\ValidationForm;
use App\Managers\SocialManager;


class SocialCRUD
{
  public function addSocial()
  {
    $validate = new ValidationForm();
    // die(var_dump($_POST)); JARRIVE A DUMP ICI
    if (!empty($_POST)) {
      // MAIS PAS ICI (Je ne sais pas pourquoi ça ne rentre jamais dans la boucle...)
      $validate->checkAddSocial($_POST);
      if (!$validate->errors) {
        foreach ($_POST as $key => $value) {
          $_POST[$key] = strip_tags($value);
        }
        $social = (new SocialManager())->createSocial($_POST);
      }
    }
    return $validate->errors;
  }
}