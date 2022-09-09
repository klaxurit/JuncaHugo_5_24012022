<?php

namespace App\Service;

class ValidationForm
{
  const STRING_REGEX = "/^[0-9a-zA-Z']*$/";
  const PASSWORD_REGEX = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[\w~@#$%^&*+=`|{}:;!.?\"()\[\]-]{8,25}$/';
  const NUMBERS_OF_CHARS = '#^.{1,255}$#';
  public $errors = [];

  /**
   * Check if field is empty and put an error message in $errors array
   *
   * @param  mixed $field
   * @param  mixed $fieldName
   * @return void
   */
  public function checkEmpty($field, $fieldName)
  {
    if (empty($field)) {
      $this->errors[$fieldName] = "Ce champ est requis";
    }
  }

  public function checkNumbersOfChars($field, $fieldName)
  {
    if (!preg_match(self::NUMBERS_OF_CHARS, $field)) {
      $this->errors[$fieldName] = "Ce champ ne peux contenir que 255 charactères maximum.";
    }
  }

  /**
   * Check if field is a string and put an error message in $errors array
   *
   * @param  mixed $field
   * @param  mixed $fieldName
   * @param  mixed $message
   * @return void
   */
  public function checkString($field, $fieldName, $message)
  {
    $this->checkEmpty($field, $fieldName);
    if (!preg_match(self::STRING_REGEX, $field)) {
      $this->errors[$fieldName] = "Le champ " . $message . " est incorrect.";
    }
    return array_push($this->errors);
  }

  /**
   * Check if field is an email and put an error message in $errors array
   *
   * @param  mixed $field
   * @param  mixed $fieldName
   * @param  mixed $message
   * @return void
   */
  public function checkEmail($field, $fieldName)
  {
    $this->checkEmpty($field, $fieldName);
    if (!filter_var($field, FILTER_VALIDATE_EMAIL)) {
      $this->errors[$fieldName] = "L'addresse email est incorrect.";
    }
    return array_push($this->errors);
  }

  /**
   * Check if field is a password and put an error message in $errors array
   *
   * @param  mixed $field
   * @param  mixed $fieldName
   * @param  mixed $message
   * @return void
   */
  public function checkPassword($field, $fieldName, $message)
  {
    $this->checkEmpty($field, $fieldName);
    if (!preg_match(self::PASSWORD_REGEX, $field)) {
      $this->errors[$fieldName] = "Le champ " . $message . " est incorrect.";
    }
    return array_push($this->errors);
  }

  /**
   * Check if 2 entered passwords or identical
   *
   * @param  mixed $field
   * @param  mixed $fieldName
   * @param  mixed $message
   * @return void
   */
  public function checkPasswordsAreSame($field1, $field2, $fieldName)
  {
    $this->checkEmpty($field1, $field2, $fieldName);
    if (strcmp($field1, $field2) !== 0) {
      $this->errors[$fieldName] = "Les mots de passes entrés ne sont pas identiques.";
    }
    return array_push($this->errors);
  }

  /**
   * Verify register form and send error if needed
   *
   * @param  mixed $form
   * @return void
   */
  public function checkRegister($form)
  {
    $this->checkString($form["lastName"], "lastName", "nom");
    $this->checkNumbersOfChars($form["lastName"], "lastNameMaxChars");
    $this->checkString($form["firstName"], "firstName", "prenom");
    $this->checkNumbersOfChars($form["firstName"], "firstNameMaxChars");
    $this->checkString($form["username"], "username", "surnom");
    $this->checkNumbersOfChars($form["username"], "usernameMaxChars");
    $this->checkEmail($form["email"], "email", "email");
    $this->checkNumbersOfChars($form["email"], "emailMaxChars");
    $this->checkPassword($form["password"], "password", "mot de passe");
    $this->checkEmpty($form["password_confirmation"], "password_confirmation", "confirmation du mdp");
    $this->checkPasswordsAreSame($form["password"], $form["password_confirmation"], "password_confirmation");
  }

  /**
   * Verify add social form and send error if needed
   *
   * @param  mixed $form
   * @return void
   */
  public function checkAddSocial($form)
  {
    $this->checkEmpty($form["iconName"], "iconName");
    $this->checkNumbersOfChars($form["iconName"], "iconNameMaxChars");
    $this->checkEmpty($form["url"], "url");
    $this->checkEmpty($form["name"], "name");
    $this->checkNumbersOfChars($form["name"], "socialNameMaxChars");
  }

  /**
   * Verify update social form and send error if needed
   *
   * @param  mixed $form
   * @return void
   */
  public function checkUpdateSocial(object $form)
  {
    $this->checkEmpty($form->getIconName(), "iconName");
    $this->checkNumbersOfChars($form->getIconName(), "iconNameMaxChars");
    $this->checkEmpty($form->getUrl(), "url");
    $this->checkEmpty($form->getName(), "name");
    $this->checkNumbersOfChars($form->getName(), "socialNameMaxChars");
  }

  /**
   * Verify add comment form and send error if needed
   *
   * @param  mixed $form
   * @return void
   */
  public function checkAddComment($form)
  {
    $this->checkEmpty($form["content"], "content");
  }

  /**
   * Verify add post form and send error if needed
   *
   * @param  mixed $form
   * @return void
   */
  public function checkPost($form)
  {
    $this->checkEmpty($form["title"], "title");
    $this->checkNumbersOfChars($form["title"], "titleMaxChars");
    $this->checkEmpty($form["caption"], "caption");
    $this->checkEmpty($form["content"], "content");
    $this->checkEmpty($form["alt_cover_image"], "alt_cover_image");
    $this->checkNumbersOfChars($form["alt_cover_image"], "altCoverImageMaxChars");
  }

  /**
   * Verify update admin form and send error if needed
   *
   * @param  mixed $form
   * @return void
   */
  public function checkUpdateAdmin(object $form)
  {
    $this->checkEmpty($form->getFirstName(), "firstname");
    $this->checkNumbersOfChars($form->getFirstName(), "firstNameMaxChars");
    $this->checkEmpty($form->getLastName(), "lastname");
    $this->checkNumbersOfChars($form->getLastName(), "lastNameMaxChars");
    $this->checkEmpty($form->getUsername(), "username");
    $this->checkNumbersOfChars($form->getUsername(), "usernameMaxChars");
  }
}
