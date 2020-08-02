<?php

namespace App\Models;

class User
{
    /**
     * @var string
     */
    private $firstName;
    
    /**
     * @var string
     */
    private $lastName;
    
    /**
     * @var string
     */
    private $email;
    
    /**
     * @var string
     */
    private $password = null;
    
    /**
     * @var int
     */
    private $active;
    
    /**
     * @var int
     */
    private $admin;
    
    /**
     * @var array
     */
    private $books;

    /**
     * Get the value of firstName
     *
     * @return  string
     */ 
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @param  string  $firstName
     *
     * @return  self
     */ 
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     *
     * @return  string
     */ 
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @param  string  $lastName
     *
     * @return  self
     */ 
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of email
     *
     * @return  string
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string  $email
     *
     * @return  self
     */ 
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     *
     * @return  string
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param  string  $password
     *
     * @return  self
     */ 
    public function setPassword(string $password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);

        return $this;
    }

    /**
     * Get the value of active
     *
     * @return  int
     */ 
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @param  int  $active
     *
     * @return  self
     */ 
    public function setActive(int $active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the value of admin
     *
     * @return  int
     */ 
    public function isAdmin()
    {
        return $this->admin;
    }

    /**
     * Set the value of admin
     *
     * @param  int  $admin
     *
     * @return  self
     */ 
    public function setAdmin(int $admin)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get the value of books
     *
     * @return  array
     */ 
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * Set the value of books
     *
     * @param  string  $books
     *
     * @return  self
     */ 
    public function setBooks(string $books)
    {
        $this->books = unserialize($books);

        return $this;
    }
}