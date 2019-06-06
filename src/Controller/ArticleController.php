<?php
/**
 * Created by PhpStorm.
 * User: thomaslarousse
 * Date: 06/06/2019
 * Time: 15:30
 */

namespace Blog\Controller;

use Blog\Entity\Article;
use Doctrine\ORM\EntityManager;

class ArticleController
{

    public static function getAll(EntityManager $entityManager)
    {
        $articles = $entityManager->getRepository(Article::class)->findAll();
        var_dump($articles);
    }

    public static function getOneBySlug(EntityManager $entityManager, $slug)
    {
        $article = $entityManager->getRepository(Article::class)->findBy([
            'slug' => $slug
        ]);
        var_dump($article);
    }

    protected function create(EntityManager $entityManager)
    {
        //todo : create forms
    }

    protected function update()
    {
        //todo : create forms
    }

    protected function remove(EntityManager $entityManager, $slug)
    {
        $article = $entityManager->getRepository(Article::class)->findBy([
            'slug' => $slug
        ]);

        $entityManager->remove($article);
    }

}