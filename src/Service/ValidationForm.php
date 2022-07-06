<?php

namespace App\Service;

class ValidationForm
{
  const stringRegex = "/^[0-9a-zA-Z']*$/";
  const passwordRegex = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[\w~@#$%^&*+=`|{}:;!.?\"()\[\]-]{8,25}$/';

  public function checkString($field, $fieldName)
  {
    if (empty($field)) {
      $errors[$fieldName] = "Le champ" . $fieldName . "est requis.";
    } else if (!preg_match(self::stringRegex, $field)) {
      $errors[$fieldName] = "Le champ" . $fieldName . "est incorrect.";
    }
  }
}
