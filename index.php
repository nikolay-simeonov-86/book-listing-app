<?php

use \App\Repository\Database;
use \App\Repository\UsersRepository;
use \App\Repository\BooksRepository;
use \App\Controllers\Controller;
use \Klein\Klein;

require __DIR__ . '/vendor/autoload.php';

// Initialize the session
session_start();

// Twig templating init
$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader);
// Added dump function to twig for debugging
$function = new \Twig\TwigFunction('dump', function ($string) {
    var_dump($string);
});
$twig->addFunction($function);

// Database and repositories init
$dbInit = new Database(getenv('USER'), getenv('PASSWORD'), getenv('DATABASE'), getenv('HOST'), getenv('CHARSET'));
$pdo = $dbInit->connect();
$usersRepository = new UsersRepository($pdo);
$booksRepository = new BooksRepository($pdo);

// Controller init
$baseUrl = '/book-listing-app/';
$controler = new Controller($baseUrl, $twig, $usersRepository, $booksRepository);

// Routes definition
$klein = new Klein();
$klein->respond('GET', $baseUrl, function ($request) use ($controler) {
    return $controler->renderWelcomeView($request);
});
$klein->respond('GET', $baseUrl . 'login', function ($request) use ($controler, $baseUrl) {
    if (array_key_exists('user', $_SESSION)) {
        header('Location: ' . $baseUrl);
        exit();
    }
    return $controler->renderLoginView($request);
});
$klein->respond('POST', $baseUrl . 'login', function ($request) use ($controler, $baseUrl) {
    if (array_key_exists('user', $_SESSION)) {
        header('Location: ' . $baseUrl);
        exit();
    }
    return $controler->login($request);
});
$klein->respond('GET', $baseUrl . 'register', function ($request) use ($controler) {
    return $controler->renderRegisterView($request);
});
$klein->respond('POST', $baseUrl . 'register', function ($request) use ($controler) {
    return $controler->register($request);
});
$klein->respond('GET', $baseUrl . 'logout', function ($request) use ($controler) {
    return $controler->logout($request);
});
$klein->respond('GET', $baseUrl . 'create-book', function ($request) use ($controler, $baseUrl) {
    if (!array_key_exists('user', $_SESSION) || $_SESSION['user']->isAdmin()) {
        header('Location: ' . $baseUrl);
        exit();
    }
    return $controler->renderCreateBookView($request);
});
$klein->respond('POST', $baseUrl . 'create-book', function ($request) use ($controler, $baseUrl) {
    if (!array_key_exists('user', $_SESSION) || $_SESSION['user']->isAdmin()) {
        header('Location: ' . $baseUrl);
        exit();
    }
    return $controler->createBook($request);
});
$klein->dispatch();
