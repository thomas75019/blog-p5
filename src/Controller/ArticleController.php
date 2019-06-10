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
use Blog\Entity\TypeUtilisateur;
use Blog\Entity\Utilisateur;

class ArticleController extends DoctrineLoader
{

    /**
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getAll()
    {
        $articles = $this->entityManager->getRepository(Article::class)->findAll();

        return $this->twig->render('index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * Get an an article with its slug
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
     * Create an article
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create()
    {
        $type = new TypeUtilisateur();
        $type->setType('admin');
        $auteur = new Utilisateur();
        $auteur->setEmail('test');
        $auteur->setMotDePasse('test');
        $auteur->setPseudo('test');
        $auteur->setType($type);


        $article = new Article();
        $article->setAuteur($auteur);
        $article->setSlug('test');
        $article->setContenu('test');
        $article->setChapo('test');
        $article->setTitre('test');


        $this->entityManager->persist($article);
        $this->entityManager->flush();
    }

    /**
     * @param $article_slug string
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update($article_slug)
    {
        $article = $this->entityManager->getRepository(Article::class)->findBy([
            'slug' => $article_slug
        ]);

        // Do the modifications

        $this->entityManager->flush();

    }

    /**
     * Remove the Article
     * @param $slug integer
     * @throws \Doctrine\ORM\ORMException
     */
    public function remove($slug)
    {
        $article = $this->entityManager->getRepository(Article::class)->findBy([
            'slug' => $slug
        ]);

        $this->entityManager->remove($article);
        $this->entityManager->flush();
    }

}