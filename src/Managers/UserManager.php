<?php

namespace App\Managers;

use App\Core\Manager;
use App\Model\User;

class UserManager extends Manager
{
  public function __construct(){
    parent::__construct();
  }

  public function findUsers()
  {
    $sql="SELECT * FROM user";
    $req=$this->pdo()->prepare($sql);
    $req->execute();
    $datas=$req->fetchAll();
    return $datas;
  }
}
