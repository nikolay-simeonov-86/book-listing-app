<?php

namespace App\Repository;

class Database
{
    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $dbName;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $charset;

    /**
     * Database constructor
     *
     * @param string $user
     * @param string $password
     * @param string $dbName
     * @param string $host
     * @param string $charset
     */
    public function __construct(string $user, string $password, string $dbName, string $host, string $charset)
    {
        $this->user = $user;
        $this->pass = $password;
        $this->dsn = "mysql:host=$host;dbname=$dbName;charset=$charset";
        $this->options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    }

    /**
     * Connect to database ant return PDO object
     *
     * @return \PDO
     * @throws \PDOException
     */
    public function connect()
    {
       try {
            return new \PDO($this->dsn, $this->user, $this->pass, $this->options);
       } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
       }
    }
}