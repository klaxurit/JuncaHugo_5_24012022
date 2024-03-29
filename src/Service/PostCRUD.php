<?php

namespace App\Service;

use App\Managers\PostManager;
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
        $validate->checkPost($postDatas);
        if (!$validate->errors) {
            (new PostManager())->createPost($postDatas);
        }
        return $validate->errors;
    }

    /**
     * Check errors and send data to manager
     *
     * @param  mixed $postDatas
     * @return void
     */
    public function updatePost($postDatas)
    {
        $validate = new ValidationForm();
        $validate->checkPost($postDatas);
        if (!$validate->errors) {
            (new PostManager())->updatePost($postDatas);
        }
        return $validate->errors;
    }
}
