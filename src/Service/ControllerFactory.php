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
    public static function newController($controller_name)
    {
        $controller = ucfirst($controller_name);

        return new $controller . 'Controller';
    }

}