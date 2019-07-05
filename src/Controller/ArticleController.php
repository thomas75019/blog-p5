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
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getList()
    {
        $articles = $this->entityManager->getRepository(Article::class)->findAll();

        echo $this->twig->render('back/articles.html.twig', [
            'articles' => $articles
        ]);
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
     * @param $data array
     */
    public function save($data)
    {
        $user = unserialize($_SESSION['user']);

        if (!isset($_SESSION['user']) && !$user->isAdmin()) {
            $this->redirect('/login');
        } else {
            $auteur = $this->entityManager->getRepository(Utilisateur::class)->find($user->getId());

            try {
                $article = new Article();

                $article->hydrate($data);
                $article->setAuteur($auteur);

                $this->entityManager->persist($article);
                $this->entityManager->flush();
                $this->flashMessage->success('L\'article a bien été ajouté');

                return $this->redirect('/list/article');
            } catch (\Exception $e) {
                $this->flashMessage->error('Erreur dans l\'ajout de l\'article :' . $e->getMessage());
                return $this->redirect('/create/article');
            }

        }
    }

    /**
     * @param int $article_id
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function update($article_id)
    {
        $article = $this->entityManager->getRepository(Article::class)->findOneBy([
            'id' => $article_id
        ]);

        echo $this->twig->render('forms/updateArticle.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @param $data array
     * @param $article_id int
     */
    public function saveUpdate($data, $article_id)
    {
        $article = $this->entityManager->getRepository(Article::class)->find($article_id);

        try {
            $article->hydrate($data);
            $this->entityManager->flush();
            $this->flashMessage->success('L\'article a été mis à jour');

            return $this->redirect('/read/' . $article->getSlug());
        } catch (\Exception $e) {
            $this->flashMessage->error('Erreur lors de la mise à jour de l\'article: ' . $e->getMessage());

            return $this->redirect('/update/article');
        }

    }

    /**
     * Remove the Article
     * @param $article_id string
     */
    public function delete($article_id)
    {
        $article = $this->entityManager->getRepository(Article::class)->find($article_id);

        try {
            $this->entityManager->remove($article);
            $this->entityManager->flush();
            $this->flashMessage->success('L\'article a bien été supprimé');

            return $this->redirect('/list/article');
        } catch (\Exception $e) {
            $this->flashMessage->error('Erreur lors de la suppression de l\'article: ' . $e->getMessage());
            return $this->redirect('/list/article');
        }

    }
}
