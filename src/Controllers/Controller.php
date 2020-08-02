<?php

namespace App\Controllers;

class Controller extends BaseController
{
    /**
     * @var \Twig\Environment
     */
    protected $twig;

    /**
     * Controller constructor
     *
     * @param \Twig\Environment $twig
     */
    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    /**
     * Render welcome view page
     *
     * @param Klein\DataCollection $request
     * @return void
     */
    public function renderWelcomeView($request)
    {
        return $this->twig->render('welcome.twig', $request->params());
        // return $this->renderView('views/welcome.php', $request->params());
    }    
}
