<?php

namespace Blog\Controller;

use Blog\Dependencies\CrsfToken;
use Blog\Dependencies\Doctrine;
use Blog\Dependencies\FlashMessage;
use Blog\Dependencies\Twig;

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
    public function __construct(Twig $twig, Doctrine $entityManager, FlashMessage $flash, CrsfToken $token)
    {

        $this->twig = $twig->getTwig();

        $this->entityManager = $entityManager->getEm();

        $this->flashMessage = $flash->getFlashMessage();

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
        die();
    }
}
