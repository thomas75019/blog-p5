<?php

namespace Blog\Service;

use Blog\Controller\ArticleController;
use Blog\Controller\CommentaireController;
use Blog\Controller\ContactController;
use Blog\Controller\UtilisateurController;

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
                $controller = new ContactController(new Mail());
                break;
            default:
                throw new \Exception('Unkown controller');
        }

        return $controller;
    }
}
