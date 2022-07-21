<?php

namespace App\Service;

use App\Service\ValidationForm;
use App\Managers\CommentManager;


class AddComment
{
  public function add($postId)
  {
    $validate = new ValidationForm();
    if (!empty($_POST)) {
    $validate->checkEmpty($_POST["content"], "content");
    // $validate->checkUserConnected($_POST["content"], "content");
        if (!$validate->errors) {
          (new CommentManager())->createComment($postId, $_POST);
        }
    }
    return $validate->errors;
  }
}