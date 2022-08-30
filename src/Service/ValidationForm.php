<?php

namespace App\Service;

class ValidationForm
{
  const stringRegex = "/^[0-9a-zA-Z']*$/";
  const passwordRegex = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[\w~@#$%^&*+=`|{}:;!.?\"()\[\]-]{8,25}$/';
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
    if (!preg_match(self::stringRegex, $field)) {
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
  public function checkEmail($field, $fieldName, $message)
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
    if (!preg_match(self::passwordRegex, $field)) {
      $this->errors[$fieldName] = "Le champ " . $message . " est incorrect.";
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
    $this->checkString($form["firstName"], "firstName", "prenom");
    $this->checkString($form["username"], "username", "surnom");
    $this->checkEmail($form["email"], "email", "email");
    $this->checkPassword($form["password"], "password", "mot de passe");
    $this->checkEmpty($form["password_confirmation"], "password_confirmation", "confirmation du mdp");
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
    $this->checkEmpty($form["url"], "url");
    $this->checkEmpty($form["name"], "name");
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
  public function checkAddPost($form)
  {
    $this->checkEmpty($form["title"], "title");
    $this->checkEmpty($form["caption"], "caption");
    $this->checkEmpty($form["content"], "content");
    $this->checkEmpty($form["alt_cover_image"], "alt_cover_image");
    $this->checkEmpty($form["slug"], "slug");
  }
}
