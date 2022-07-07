<?php

namespace App\Service;

class ValidationForm
{
  const stringRegex = "/^[0-9a-zA-Z']*$/";
  const passwordRegex = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[\w~@#$%^&*+=`|{}:;!.?\"()\[\]-]{8,25}$/';
  const usernameRegex = "/^[0-9a-zA-Z']*$/";
  public $errors = [];

  public function checkEmpty($field, $fieldName)
  {
    if (empty($field)) {
      $this->errors[$fieldName] = "Le champ " . $fieldName . " est requis.";
    }
  }

  public function checkString($field, $fieldName)
  {
    $this->checkEmpty($field, $fieldName);
    if (!preg_match(self::stringRegex, $field)) {
      $this->errors[$fieldName] = "Le champ " . $fieldName . " est incorrect.";
    }
    return array_push($this->errors);
  }

  public function checkStringAndNumber($field, $fieldName)
  {
    $this->checkEmpty($field, $fieldName);
    if (!preg_match(self::usernameRegex, $field)) {
      $errors[$fieldName] = "Le champ " . $fieldName . " est incorrect.";
    }
    return array_push($this->errors);
  }

  public function checkEmail($field, $fieldName)
  {
    $this->checkEmpty($field, $fieldName);
    if (!filter_var($field, FILTER_VALIDATE_EMAIL)) {
      $this->errors[$fieldName] = "L'addresse email est incorrect.";
    }
    return array_push($this->errors);
  }

  public function checkPassword($field, $fieldName)
  {
    $this->checkEmpty($field, $fieldName);
    if (!preg_match(self::passwordRegex, $field)) {
      $this->errors[$fieldName] = "Le champ " . $fieldName . " est incorrect.";
    }
    return array_push($this->errors);
  }

  public function checkRegister($form)
  {
    $this->checkString($form["lastName"], "lastName");
    $this->checkString($form["firstName"], "firstName");
    $this->checkStringAndNumber($form["username"], "username");
    $this->checkEmail($form["email"], "email");
    $this->checkPassword($form["password"], "password");
    $this->checkEmpty($form["password_confirmation"], "password_confirmation");
  }
}
