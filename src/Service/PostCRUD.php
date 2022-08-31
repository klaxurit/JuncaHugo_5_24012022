<?php

namespace App\Service;

use App\Managers\PostManager;
use App\Managers\SocialManager;
use App\Service\ValidationForm;

class PostCRUD
{
  /**
   * Check errors and send data to manager
   *
   * @return void
   */
  public function addPost($postDatas)
  {
    $validate = new ValidationForm();
    $validate->checkAddPost($postDatas);
    if (!$validate->errors) {
      (new PostManager())->CreatePost($postDatas);
    }
    return $validate->errors;
  }

  /**
   * Check errors and send data to manager
   *
   * @param  mixed $id
   * @return void
   */
  public function updatePost($postDatas)
  {
    $validate = new ValidationForm();
    if (!$validate->errors) {
      (new PostManager())->updatePost($postDatas);
    }
    return $validate->errors;
  }
}
