<?php

namespace Blog\Service;

use Blog\Controller\ArticleController;
use Blog\Controller\CommentaireController;
use Blog\Controller\ContactController;
use Blog\Controller\HomeController;
use Blog\Controller\UtilisateurController;
use Blog\Dependencies\CrsfToken;
use Blog\Dependencies\Twig;
use Blog\Dependencies\Doctrine;
use Blog\Service\UserSession;
use Blog\Dependencies\FlashMessage;

/**
 * Class ControllerFactory
 *
 * Factory which instanciate controllers used in index.php
 *
 * @package Blog\Service
 */
class ControllerFactory
{
    /**
     * Creates a new Controller class instance
     *
     * @param string $controller_name Controller name
     *
     * @return ArticleController|UtilisateurController|CommentaireController|ContactController
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception
     */
    public static function newController($controller_name)
    {
        $session = new UserSession();
        $twig = new Twig($session);
        $entityManager = new Doctrine();
        $flash = new FlashMessage();
        $mail = new Mail();
        $token = new CrsfToken();

        switch (strtolower($controller_name)) {
            case 'article':
                $controller = new ArticleController($twig, $entityManager, $flash, $token);
                break;
            case 'utilisateur':
                $controller = new UtilisateurController($twig, $entityManager, $flash, $token);
                break;
            case 'commentaire':
                $controller = new CommentaireController($twig, $entityManager, $flash, $token);
                break;
            case 'contact':
                $controller = new ContactController($mail);
                break;
            case 'home':
                $controller = new HomeController($twig);
                break;
            default:
                throw new \Exception('Unkown controller');
        }

        return $controller;
    }
}
