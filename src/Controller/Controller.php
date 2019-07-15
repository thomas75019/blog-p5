<?php

namespace Blog\Controller;

use Blog\Dependencies\Doctrine;
use Blog\Dependencies\FlashMessage;
use Blog\Dependencies\Twig;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Blog\Config\DbConfig;
use Plasticbrain\FlashMessages\FlashMessages;
use Blog\Service\Mail;

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

    /**
     * Controller constructor.
     *
     * @param Twig         $twig          Twig
     * @param Doctrine     $entityManager Entity Manager
     * @param FlashMessage $flash         Flash messages
     */
    public function __construct(Twig $twig, Doctrine $entityManager, FlashMessage $flash)
    {

        $this->twig = $twig->getTwig();

        $this->entityManager = $entityManager->getEm();

        $this->flashMessage = $flash->getFlashMessage();

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
