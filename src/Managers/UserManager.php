<?php

namespace App\Managers;

use PDO;
use App\Model\User;
use App\Core\Manager;

class UserManager extends Manager
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Find all users
     *
     * @return void
     */
    public function findUsers()
    {
        $sql = "SELECT * FROM user";
        $req = $this->pdo->prepare($sql);
        $req->execute();
        $datas = $req->fetchAll(PDO::FETCH_COLUMN, 2);
        $users = new User($datas);

        return $users;
    }

    /**
     * Find one user by id
     *
     * @param  mixed $userId
     * @return void
     */
    public function findOneUser(int $userId)
    {
        $sql = "SELECT * FROM user WHERE id=:id";

        $req = $this->pdo->prepare($sql);
        $req->bindParam(':id', $userId, PDO::PARAM_STR);
        $req->execute();

        $data = $req->fetch();

        $user = new User($data);

        return $user;
    }

    /**
     * Add user in database
     *
     * @return void
     */
    public function createUser($user)
    {
        $user = new User($user);
        // hash password using password ARGON2ID
        // (ARGON2ID algorithm most powerfull than BCRYPT and ARGON2I)
        $password = password_hash($user->getPassword(), PASSWORD_ARGON2ID);

        $sql = "INSERT INTO `user`(`firstname`, `lastname`, `username`, `email`, `password`) VALUES (:lastName, :firstName, :username, :email, :pass)";
        $req = $this->pdo->prepare($sql);
        $req->bindValue(':lastName', $user->getLastname(), PDO::PARAM_STR);
        $req->bindValue(':firstName', $user->getFirstname(), PDO::PARAM_STR);
        $req->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
        $req->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $req->bindValue(':pass', $password, PDO::PARAM_STR);

        $req->execute();

        // get new user's id
        $userId = $this->pdo->lastInsertId();

        $sql = "SELECT * FROM user WHERE id = :id";
        $req = $this->pdo->prepare($sql);
        $req->bindParam(':id', $userId, PDO::PARAM_STR);
        $req->execute();
        $datas = $req->fetch();

        $user = new User($datas);

        return $user;
    }

    /**
     * Log-in an user
     *
     * @return void
     */
    public function loginUser()
    {
        $sql = "SELECT * FROM `user` WHERE `email` = :email";
        $req = $this->pdo->prepare($sql);
        $req->bindParam(':email', $_POST["email"], PDO::PARAM_STR);

        $req->execute();
        $datas = $req->fetch();

        return ($datas) ? new User($datas) : null;
    }
}
