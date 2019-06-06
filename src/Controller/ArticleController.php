<?php
/**
 * Created by PhpStorm.
 * User: thomaslarousse
 * Date: 06/06/2019
 * Time: 15:30
 */

namespace Blog\Controller;

use Blog\DoctrineLoader;
use Blog\Entity\Article;
use Blog\Entity\Utilisateur;
use Doctrine\ORM\EntityManager;
use http\Env\Response;


class ArticleController extends DoctrineLoader
{


    /**
     * @return Article
     */
    public function getAll()
    {
        $articles = $this->entityManager->getRepository(Article::class)->findAll();

        var_dump($articles);
    }

    /**
     * @param $slug integer
     * @return Article
     */
    public function getOneBySlug($slug)
    {
        $article = $this->entityManager->getRepository(Article::class)->findBy([
            'slug' => $slug
        ]);
        var_dump($article);
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create()
    {
        $auteur = new Utilisateur();
        $auteur->setEmail('test');
        $auteur->setMotDePasse('test');
        $auteur->setPseudo('test');


        $article = new Article();
        $article->setAuteur($auteur);
        $article->setSlug('test');
        $article->setContenu('test');
        $article->setChapo('test');


        $this->entityManager->persist($article);
        $this->entityManager->flush();
    }

    protected function update()
    {
        //todo : create forms
    }

    /**
     * @param $slug integer
     * @throws \Doctrine\ORM\ORMException
     */
    protected function remove($slug)
    {
        $article = $this->entityManager->getRepository(Article::class)->findBy([
            'slug' => $slug
        ]);

        $this->entityManager->remove($article);
    }

}