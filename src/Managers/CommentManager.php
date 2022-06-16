<?php

namespace App\Managers;

use PDO;
use App\Model\Post;
use App\Model\User;
use App\Core\Manager;

class CommentManager extends Manager
{
  public function __construct()
  {
    parent::__construct();
  }

  public function findAllPostComments()
  {
    // find all post comments
  }
}
