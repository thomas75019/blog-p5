<?php
/**
 * Class ArticleController
 *
 * @package Blog\Controller
 */

namespace Blog\Controller;

use Blog\DoctrineLoader;
use Blog\Entity\Article;
use Blog\Entity\Commentaire;
use Blog\Entity\Utilisateur;

class ArticleController extends DoctrineLoader
{

    /**
     * Render the index page
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getAll()
    {
        $articles = $this->entityManager->getRepository(Article::class)->findAll();

        echo $this->twig->render(
            'front/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * Render the page with all articles
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getList()
    {
        $articles = $this->entityManager->getRepository(Article::class)->findAll();

        echo $this->twig->render('back/articles.html.twig',[
            'articles' => $articles
        ]);
    }

    /**
     * Render a single article page
     *
     * @param string  $slug
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getOneBySlug($slug)
    {
        $articleRepo = $this->entityManager->getRepository(Article::class);
        $article = $articleRepo->findOneBy([
            'slug' => $slug
        ]);

        $commentaireRepo = $this->entityManager->getRepository(Commentaire::class);
        $commentaires = $commentaireRepo->findBy([
            'article' => $article,
            'valide' => false
        ]);

        echo $this->twig->render(
            'front/viewOne.html.twig', [
            'article' => $article,
            'commentaires' => $commentaires
        ]);
    }

    /**
     * Render create Article form
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function create()
    {
        echo $this->twig->render('forms/createArticle.html.twig');
    }

    /**
     * Save the article in database
     *
     * @param array  $data
     */
    public function save($data)
    {
        $user = unserialize($_SESSION['user']);

        $auteurRepo = $this->entityManager->getRepository(Utilisateur::class);
        $auteur = $auteurRepo->find($user->getId());

        try {
            $article = new Article();

            $article->hydrate($data);
            $article->setAuteur($auteur);

            $this->entityManager->persist($article);
            $this->entityManager->flush();
            $this->flashMessage->success('L\'article a bien été ajouté');

            return $this->redirect('/list/article');
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            $this->flashMessage->error('Erreur dans l\'ajout de l\'article :' . $msg);
            return $this->redirect('/create/article');
        }
    }

    /**
     * Render the update article page
     *
     * @param int  $article_id
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function update($article_id)
    {
        $articleRep = $this->entityManager->getRepository(Article::class);
        $article = $articleRep->find($article_id);

        echo $this->twig->render(
            'forms/updateArticle.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * Save the updates
     *
     * @param array  $data
     * @param int $article_id
     */
    public function saveUpdate($data, $article_id)
    {
        $articleRepo = $this->entityManager->getRepository(Article::class);
        $article = $articleRepo->find($article_id);

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
     *
     * @param string  $article_id
     */
    public function delete($article_id)
    {
        $articleRepo = $this->entityManager->getRepository(Article::class);
        $article = $articleRepo->find($article_id);

        try {
            $this->entityManager->remove($article);
            $this->entityManager->flush();
            $this->flashMessage->success('L\'article a bien été supprimé');

            return $this->redirect('/list/article');
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            $this->flashMessage->error('Erreur lors de la suppression de l\'article: ' . $msg);
            return $this->redirect('/list/article');
        }
    }
}
