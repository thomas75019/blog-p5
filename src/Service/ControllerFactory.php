<?php
/**
 * Created by PhpStorm.
 * User: thomaslarousse
 * Date: 09/06/2019
 * Time: 19:12
 */

namespace Blog\Service;

use Blog\Controller\ArticleController;
use CommentaireController;
use Blog\Controller\UtilisateurController;

class ControllerFactory
{
    /**
     * @param $controller_name
     * @return ArticleController|UtilisateurController|CommentaireController
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
            default:
                throw new \Exception('Unkown controller');
        }

        return $controller;
    }
}
