<?php
namespace Blog\Controller;

use Blog\Dependencies\Twig;

class HomeController extends Controller
{

    /**
     * Render the homepage
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function homePage()
    {
        $this->render('front/home.html.twig');
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function homeAdmin()
    {
        $this->render('back/adminHome.html.twig');
    }
}
