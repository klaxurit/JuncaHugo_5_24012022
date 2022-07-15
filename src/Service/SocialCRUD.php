<?php

namespace App\Service;

use App\Service\ValidationForm;
use App\Managers\SocialManager;


class SocialCRUD
{
  public function addSocial()
  {
    $validate = new ValidationForm();
    $validate->checkAddSocial($_POST);
    if (!$validate->errors) {
      foreach ($_POST as $key => $value) {
        $_POST[$key] = strip_tags($value);
      }
      // $social = new Social($_POST);
      // Voir pour gérrer les insertions 
      (new SocialManager())->createSocial($_POST);
    }
    return $validate->errors;
  }

  public function modifySocial(int $id)
  {
    // récuperrer les champs pour pré remplir le formulaire
    $validate = new ValidationForm();
    // $validate->checkAddSocial($_POST);
    if (!$validate->errors) {
      foreach ($_POST as $key => $value) {
        $_POST[$key] = strip_tags($value);
      }
      (new SocialManager())->updateSocial($id);
    }
    return $validate->errors;
  }
}