<?php

namespace App\Service;

use PDO;
use App\Model\Post;
use App\Core\PDOFactory;

class PaginationService
{
  public function __construct()
  {
    $this->pdo = (new PDOFactory())->getSQLConnexion();
  }

  public function paginate()
  {
    $sql = "SELECT COUNT(id) as totalPosts FROM post";
    $req = $this->pdo->prepare($sql);
    $req->execute();
    $datas = $req->fetch();

    $totalPosts = $datas['totalPosts'];
    $perPage = 4;
    $currentPage = 1;
  }
}
