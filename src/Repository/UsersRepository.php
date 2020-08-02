<?php

namespace App\Repository;

use App\Models\User;

class UsersRepository
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * User repository constructor
     *
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Insert new user into the database
     *
     * @param User $user
     * @return array
     */
    public function insert(User $user)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (firstName, lastName, email, password, active, admin) 
            VALUES (?,?,?,?,?,?)");
        return $stmt->execute([$user->getFirstName(), $user->getLastName(), $user->getEmail(), $user->getPassword(), $user->isActive(), $user->isAdmin()]);
    }

    /**
     * Login user
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login(string $email, string $password)
    {
        $stmt = $this->pdo->query("SELECT * FROM users WHERE email = '$email'");
        $user = $stmt->fetch();
        
        return password_verify($password, $user['password']);
    }

    /**
     * Get one user by email from database
     *
     * @param string $email
     * @return array
     */
    public function getOneByEmail(string $email)
    {
        $stmt = $this->pdo->query("SELECT * FROM users WHERE email = '$email'");
        return $stmt->fetch();
    }
}
