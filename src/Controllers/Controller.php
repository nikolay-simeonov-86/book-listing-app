<?php

namespace App\Controllers;

use App\Models\User;
use App\Repository\UsersRepository;
use App\Repository\BooksRepository;

class Controller
{
    /**
     * @var string
     */
    protected $baseUrl;
    
    /**
     * @var \Twig\Environment
     */
    protected $twig;

    /**
     * @var UsersRepository
     */
    protected $usersRepository;

    /**
     * @var BooksRepository
     */
    protected $booksRepository;

    /**
     * Controller constructor
     *
     * @param string $baseUrl
     * @param \Twig\Environment $twig
     * @param UsersRepository $usersRepository
     */
    public function __construct(string $baseUrl, \Twig\Environment $twig, UsersRepository $usersRepository, BooksRepository $booksRepository)
    {
        $this->baseUrl = $baseUrl;
        $this->twig = $twig;
        $this->usersRepository = $usersRepository; 
        $this->booksRepository = $booksRepository; 
    }

    /**
     * Render welcome view page
     *
     * @param Klein\DataCollection $request
     * @return string The rendered template
     * @throws LoaderError  When the template cannot be found
     * @throws SyntaxError  When an error occurred during compilation
     * @throws RuntimeError When an error occurred during rendering
     */
    public function renderWelcomeView($request)
    {
        return $this->twig->render('welcome.twig', ['session' => $_SESSION, 'request' => $request]);
    }

    /**
     * Render login view page
     *
     * @param Klein\DataCollection $request
     * @return string The rendered template
     * @throws LoaderError  When the template cannot be found
     * @throws SyntaxError  When an error occurred during compilation
     * @throws RuntimeError When an error occurred during rendering
     */
    public function renderLoginView($request)
    {
        return $this->twig->render('login.twig', ['session' => $_SESSION, 'request' => $request]);
    }

    /**
     * Login user function
     *
     * @param Klein\DataCollection $request
     * @return void
     */
    public function login($request)
    {
        $email = $request->paramsPost()->get('email');
        $password = $request->paramsPost()->get('password');
        $success = $this->usersRepository->login($email, $password);
        if ($success) {
            $dbUser = $this->usersRepository->getOneByEmail($email);
            $user = (new User())
                ->setFirstName($dbUser['firstName'])
                ->setLastName($dbUser['lastName'])
                ->setEmail($dbUser['email'])
                ->setPassword($dbUser['password'])
                ->setActive($dbUser['active'])
                ->setAdmin($dbUser['admin']);
            $_SESSION['user'] = $user;
            header('Location: ' . $this->baseUrl);
            exit();
        }

        return $this->twig->render('login.twig', ['error' => 'Invalid credentials', 'session' => $_SESSION, 'request' => $request]);
    }

    /**
     * Render register view page
     *
     * @param Klein\DataCollection $request
     * @return string The rendered template
     * @throws LoaderError  When the template cannot be found
     * @throws SyntaxError  When an error occurred during compilation
     * @throws RuntimeError When an error occurred during rendering
     */
    public function renderRegisterView($request)
    {
        return $this->twig->render('register.twig', ['session' => $_SESSION, 'request' => $request]);
    }

    /**
     * Register new user function
     *
     * @param Klein\DataCollection $request
     * @return void
     */
    public function register($request)
    {
        $firstName = $request->paramsPost()->get('first_name');
        $lastName = $request->paramsPost()->get('last_name');
        $email = $request->paramsPost()->get('email');
        $password = $request->paramsPost()->get('password');
        $confirmPassword = $request->paramsPost()->get('confirm_password');
        if ($password !== $confirmPassword) {
            return $this->twig->render('register.twig', ['error' => 'Passwords don\'t match', 'session' => $_SESSION, 'request' => $request]);
        }

        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
            return $this->twig->render('register.twig', ['error' => 'Invalid password', 'session' => $_SESSION, 'request' => $request]);
        }

        $user = (new User())
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setPassword($password)
            ->setActive(0)
            ->setAdmin(0);
        $this->usersRepository->insert($user);
        $_SESSION['user'] = $user;
        header('Location: ' . $this->baseUrl);
        exit();
    }

    /**
     * Logout user function
     *
     * @param Klein\DataCollection $request
     * @return void
     */
    public function logout($request)
    {
        session_destroy();
        header('Location: ' . $this->baseUrl, true, 301);
        exit();
    }

    /**
     * Logout user function
     *
     * @param Klein\DataCollection $request
     * @return void
     */
    public function renderCreateBookView($request)
    {
        return $this->twig->render('create-book.twig', ['session' => $_SESSION, 'request' => $request]);
    }

    /**
     * Logout user function
     *
     * @param Klein\DataCollection $request
     * @return void
     */
    public function createBook($request)
    {
        echo '<pre>';
        print_r($request->files()->get('image'));
        echo '</pre>';
        move_uploaded_file($request->files()->get('image')['tmp_name'], __DIR__.'/../../resources/images/'. time() . $_FILES["image"]['name']);
        // var_dump($request->paramsPost()->get('image'));
    }
}
