<?php

namespace App\Service;

class ValidationForm
{
  const stringRegex = "/^[0-9a-zA-Z']*$/";
  const passwordRegex = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[\w~@#$%^&*+=`|{}:;!.?\"()\[\]-]{8,25}$/';
  const usernameRegex = "/^[0-9a-zA-Z']*$/";
  public $errors = [];

  public function checkString($field, $fieldName)
  {
    if (empty($field)) {
      $this->errors[$fieldName] = "Le champ " . $fieldName . " est requis.";
    } else if (!preg_match(self::stringRegex, $field)) {
      $this->errors[$fieldName] = "Le champ " . $fieldName . " est incorrect.";
    }
    return array_push($this->errors);
  }

  public function checkUsername($field, $fieldName)
  {
    if (empty($field)) {
      $errors[$fieldName] = "Le champ " . $fieldName . " est requis.";
    } else if (!preg_match(self::usernameRegex, $field)) {
      $errors[$fieldName] = "Le champ " . $fieldName . " est incorrect.";
    }
    return array_push($this->errors);
  }

  public function checkEmail($field, $fieldName)
  {
    if (empty($field)) {
      $this->errors[$fieldName] = "Le champ " . $fieldName . " est requis.";
    }
    if (!filter_var($field, FILTER_VALIDATE_EMAIL)) {
      $this->errors[$fieldName] = "L'addresse email est incorrect.";
    }
    return array_push($this->errors);
  }

  public function checkPassword($field, $fieldName)
  {
    if (empty($field)) {
      $this->errors[$fieldName] = "Le champ " . $fieldName . " est requis.";
    } else if (!preg_match(self::passwordRegex, $field)) {
      $this->errors[$fieldName] = "Le champ " . $fieldName . " est incorrect.";
    }

    return array_push($this->errors);
  }

  public function checkPasswordConfirmation($field, $fieldName)
  {
    if (empty($field)) {
      $this->errors[$fieldName] = "Le champ " . $fieldName . " est requis.";
    }
    return array_push($this->errors);
  }
}
