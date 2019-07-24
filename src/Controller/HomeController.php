<?php
namespace Blog\Controller;

use Blog\Controller\Controller;
use Blog\Dependencies\Twig;

class HomeController
{
    /**
     * @var \Twig\Environment
     */
    private $twig;

    /**
     * HomeController constructor.
     *
     * @param Twig $twig Twig depedency
     */
    public function __construct(Twig $twig)
    {
        $this->twig = $twig->getTwig();
    }

    /**
     * Render the homepage
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function homePage()
    {
        echo $this->twig->render('front/home.html.twig');

    }

    public function homeAdmin()
    {
        echo $this->twig->render('back/adminHome.html.twig');
    }
}