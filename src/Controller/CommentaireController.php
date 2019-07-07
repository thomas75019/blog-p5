<?php

namespace Blog\Controller;

use Blog\Entity\Article;
use Blog\Entity\Commentaire;
use Blog\DoctrineLoader;
use Blog\Entity\Utilisateur;

/**
 * Class CommentaireController
 *
 * @package Blog\Controller
 */
class CommentaireController extends DoctrineLoader
{

    /**
     * Render the page with the list of comments
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getAll()
    {
        $commentaires = $this->entityManager->getRepository(Commentaire::class)->findAll();

        echo $this->twig->render('back/viewAllComments.html.twig', [
            'commentaires' => $commentaires
        ]);
    }

    /**
     * Save a comment in database
     *
     * @param int $article_id
     * @param Utilisateur $auteur
     * @param string $contenu
     */
    public function save($article_id, $auteur, $contenu)
    {
        $article = $this->entityManager->getRepository(Article::class)->find($article_id);
        $auteurComment = $this->entityManager->getRepository(Utilisateur::class)->find($auteur->getId());

        try {
            $commentaire = new Commentaire();
            $commentaire->hydrate($contenu);
            $commentaire->setArticle($article);
            $commentaire->setAuteur($auteurComment);

            $this->entityManager->persist($commentaire);
            $this->entityManager->flush();
            $this->flashMessage->success('Commentaire ajouté');

            return $this->redirect('/read/' . $article->getSlug());
        } catch (\Exception $e) {
            $this->flashMessage->error('Erreur lors de l\'ajout du commentaire');
            return $this->redirect('/read/' . $article->getslug());
        }
    }

    /**
     * Set a comment as valid
     *
     * @param string  $commentaire_id
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function setValide($commentaire_id)
    {
        $commentaire = $this->entityManager->getRepository(Commentaire::class)->find($commentaire_id);

        $commentaire->setValide(true);

        $this->entityManager->flush();

        $this->flashMessage->success('Commentaire validé');

        return $this->redirect('/admin/comments');
    }

    /**
     * Set a comment as invalid
     *
     * @param string  $commentaire_id
     */
    public function setInvalide($commentaire_id)
    {
        $commentaire = $this->entityManager->getRepository(Commentaire::class)->find($commentaire_id);

        try {
            $commentaire->setValide(false);

            $this->entityManager->flush();

            $this->flashMessage->success('Commentaire invalidé');

            return $this->redirect('/admin/comments');
        } catch (\Exception $e) {
            $this->flashMessage->error('Une erreur c\'est produite: ' . $e->getMessage());
            return $this->redirect('/admin/comments');
        }
    }


    /**
     * Delete a comment
     *
     * @param string  $commentaire_id
     */
    public function delete($commentaire_id)
    {
        $commentaire = $this->entityManager->getRepository(Commentaire::class)->find($commentaire_id);

        try {
            $this->entityManager->remove($commentaire);
            $this->entityManager->flush();

            $this->flashMessage->success('commentaire supprimé');

            return $this->redirect("/admin/comments");
        } catch (\Exception $e) {
            $this->flashMessage->error('Une erreur c\'est produite: ' . $e->getMessage());
            return $this->redirect('/admin/comments');
        }
    }
}
