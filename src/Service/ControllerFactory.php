<?php

namespace Blog\Service;

use Blog\Controller\ArticleController;
use Blog\Controller\CommentaireController;
use Blog\Controller\ContactController;
use Blog\Controller\UtilisateurController;
use Blog\Dependencies\Twig;
use Blog\Dependencies\Doctrine;
use Blog\Service\UserSession;
use Blog\Dependencies\FlashMessage;

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

        switch (strtolower($controller_name))
        {
            case 'article':
                $controller = new ArticleController($twig, $entityManager, $flash);
                break;
            case 'utilisateur':
                $controller = new UtilisateurController($twig, $entityManager, $flash);
                break;
            case 'commentaire':
                $controller = new CommentaireController($twig, $entityManager, $flash);
                break;
            case 'contact':
                $controller = new ContactController($mail);
                break;
            default:
                throw new \Exception('Unkown controller');
        }

        return $controller;
    }
}
