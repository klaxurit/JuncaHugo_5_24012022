<?php

namespace App\Service;

use App\Service\ValidationForm;
use App\Managers\SocialManager;


class SocialCRUD
{
  public function addSocial()
  {
    $validate = new ValidationForm();
    if (!empty($_POST)) {
      $validate->checkEmpty($_POST["iconName"], "content", "nom de l'icon");
      $validate->checkEmpty($_POST["socialUrl"], "content", "url");
      $validate->checkEmpty($_POST["socialName"], "socialName", "nom");
      if (!$validate->errors) {
        foreach ($_POST as $key => $value) {
            $_POST[$key] = strip_tags($value);
        }
        $social = (new SocialManager())->createSocial($_POST);
        header("Refresh:0");
      }
    }
    return $validate->errors;
  }
}