<?php

namespace App\Repository;

use App\Models\Book;

class BooksRepository
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * Book repository constructor
     *
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Insert new book into the database
     *
     * @param Book $book
     * @return array
     */
    public function insert(Book $book)
    {
        $stmt = $this->pdo->prepare("INSERT INTO books (name, ISBN, description, image) 
            VALUES (?,?,?,?)");
        return $stmt->execute([$book->getName(), $book->getIsbn(), $book->getDescription(), $book->getImage()]);
    }

    /**
     * Get one book by id from the database
     *
     * @param string $id
     * @return array
     */
    public function getOneById(string $id)
    {
        $stmt = $this->pdo->query("SELECT * FROM books WHERE id = '$id'");
        return $stmt->fetch();
    }

    /**
     * Get all books from the database
     * 
     * @return array
     */
    public function getAll()
    {
        return $this->pdo->query("SELECT * FROM books")->fetchAll(\PDO::FETCH_ASSOC);
    }
}
