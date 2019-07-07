<?php

namespace Blog\Service;

use Blog\Controller\ArticleController;
use Blog\Controller\CommentaireController;
use Blog\Controller\ContactController;
use Blog\Controller\UtilisateurController;

/**
 * Class ControllerFactory
 *
 * @package Blog\Service
 * @see Index
 */
class ControllerFactory
{
    /**
     * Creates a new Controller class instance
     *
     * @param string  $controller_name
     *
     * @return ArticleController|UtilisateurController|CommentaireController
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception
     */
    public static function newController($controller_name)
    {
        switch (strtolower($controller_name)) {
            case 'article':
                $controller = new ArticleController();
                break;
            case 'utilisateur':
                $controller = new UtilisateurController();
                break;
            case 'commentaire':
                $controller = new CommentaireController();
                break;
            case 'contact':
                $controller = new ContactController();
                break;
            default:
                throw new \Exception('Unkown controller');
        }

        return $controller;
    }
}
