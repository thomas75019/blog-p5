<?php

namespace Blog\Controller;

use Blog\Dependencies\CrsfToken;
use Blog\Dependencies\Doctrine;
use Blog\Dependencies\FlashMessage;
use Blog\Dependencies\Twig;
use http\Env\Response;
use Zend\Diactoros\Response\RedirectResponse;

/**
 * Class Controller
 *
 * Load EntityManager and Twig
 * and s
 *
 * @package Blog
 */
class Controller
{
    const ERR_GENERIC = "Une erreur est apparu: ";

    protected $twig;

    protected $entityManager;

    protected $flashMessage;

    protected $CrsfToken;

    /**
     * Controller constructor.
     *
     * @param Twig         $twig          Twig
     * @param Doctrine     $entityManager Entity Manager
     * @param FlashMessage $flash         Flash messages
     * @param CrsfToken    $token         Crsf Token
     */
    public function __construct(
        Twig $twig,
        Doctrine $entityManager,
        FlashMessage $flash,
        CrsfToken $token
    ) {
        $this->twig = $twig->getTwig();

        $this->entityManager = $entityManager->getEm();

        $this->flashMessage = $flash->getFlash();

        $this->CrsfToken = $token->getStoredToken();
    }

    /**
     * @param string $url        URL
     * @param int    $statusCode Status Code
     *
     * @return void
     */
    protected function redirect($url, $statusCode = 302)
    {
        header('Location: ' . $url, true, $statusCode);
    }

    /**
     * @param string $path    Template path
     * @param array  $options Options
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     *
     * @return void
     */
    protected function render($path, array $options = [])
    {
        echo $this->twig->render($path, $options);
    }
}
