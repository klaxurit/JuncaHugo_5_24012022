<?php

namespace App\Service;

class ValidationForm
{
  const stringRegex = "/^[0-9a-zA-Z']*$/";
  const passwordRegex = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[\w~@#$%^&*+=`|{}:;!.?\"()\[\]-]{8,25}$/';
  public $errors = [];

  public function checkEmpty($field, $fieldName)
  {
    if (empty($field)) {
      $this->errors[$fieldName] = "Ce champ est requis";
    }
  }

  public function checkString($field, $fieldName, $message)
  {
    $this->checkEmpty($field, $fieldName);
    if (!preg_match(self::stringRegex, $field)) {
      $this->errors[$fieldName] = "Le champ " . $message . " est incorrect.";
    }
    return array_push($this->errors);
  }

  public function checkEmail($field, $fieldName, $message)
  {
    $this->checkEmpty($field, $fieldName);
    if (!filter_var($field, FILTER_VALIDATE_EMAIL)) {
      $this->errors[$fieldName] = "L'addresse email est incorrect.";
    }
    return array_push($this->errors);
  }

  public function checkPassword($field, $fieldName, $message)
  {
    $this->checkEmpty($field, $fieldName);
    if (!preg_match(self::passwordRegex, $field)) {
      $this->errors[$fieldName] = "Le champ " . $message . " est incorrect.";
    }
    return array_push($this->errors);
  }

  // public function checkUserConnected($fieldName)
  // {
  //   if (!isset($_SESSION['user'])) {
  //     $this->errors[$fieldName] = "Vous devez être connecté pour poster un commentaire.";
  //   }
  // }

  public function checkRegister($form)
  {
    $this->checkString($form["lastName"], "lastName", "nom");
    $this->checkString($form["firstName"], "firstName", "prenom");
    $this->checkString($form["username"], "username", "surnom");
    $this->checkEmail($form["email"], "email", "email");
    $this->checkPassword($form["password"], "password", "mot de passe");
    $this->checkEmpty($form["password_confirmation"], "password_confirmation", "confirmation du mdp");
  }

  public function checkAddSocial($form)
  {
    $this->checkEmpty($form["iconName"], "iconName", "nom de l'icon");
    $this->checkEmpty($form["socialUrl"], "socialUrl", "url");
    $this->checkEmpty($form["socialName"], "socialName", "nom");
  }
}
