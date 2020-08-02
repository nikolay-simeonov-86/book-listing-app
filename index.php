<?php

require __DIR__ . '/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader);

use \App\Controllers\Controller;
use \Klein\Klein;

$controler = new Controller($twig);
$klein = new Klein();

$klein->respond('GET', '/book-listing-app/welcome', function ($request) use ($controler) {
    return $controler->renderWelcomeView($request);
});

$klein->dispatch();
