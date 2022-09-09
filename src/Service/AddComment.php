<?php

namespace App\Service;

use App\Service\ValidationForm;
use App\Managers\CommentManager;

/**
 * Add a comment
 */
class AddComment
{
    public function add($postId, $commentDatas)
    {
        $validate = new ValidationForm();
        $validate->checkAddComment($commentDatas);
        if (!$validate->errors) {
            (new CommentManager())->createComment($postId, $commentDatas);
        }
        return $validate->errors;
    }
}
