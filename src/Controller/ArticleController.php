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
use Blog\Entity\Commentaire;
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

        echo $this->twig->render('front/index.html.twig', [
            'articles' => $articles
        ]);

        var_dump($_SESSION['user']);


    }

    /**
     * @param $slug
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getOneBySlug($slug)
    {
        $article = $this->entityManager->getRepository(Article::class)->findOneBy([
            'slug' => $slug
        ]);

        $commentaires = $this->entityManager->getRepository(Commentaire::class)->findBy([
            'article' => $article,
            'valide' => false
        ]);

        //var_dump($article);
        echo $this->twig->render('front/viewOne.html.twig', [
            'article' => $article,
            'commentaires' => $commentaires
        ]);
    }

    /**
     * Render create Article form
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function create()
    {
        echo $this->twig->render('forms/createArticle.html.twig');
    }

    /**
     * @param $data
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save($data)
    {
        $session = unserialize($_SESSION['user']);

        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
        } else {
            $auteur = $this->entityManager->getRepository(Utilisateur::class)->find($session->getId());

            $article = new Article();

            $article->hydrate($data);
            $article->setAuteur($auteur);

            $this->entityManager->persist($article);
            $this->entityManager->flush();

            return $this->redirect('/');
        }
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
