<?php

namespace Blog\Controller;

use Blog\Entity\Article;
use Blog\Entity\Commentaire;
use Blog\Controller\Controller;
use Blog\Entity\Utilisateur;

class CommentaireController extends Controller
{

    const ERR_ADD = 'Erreur lors de l\'ajout du commentaire';

    /**
     * Render the page with the list of comments
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getAll()
    {
        $commentRepo = $this->entityManager->getRepository(Commentaire::class);
        $comments = $commentRepo->findAll();

        echo $this->twig->render(
            'back/viewAllComments.html.twig', [
                'commentaires' => $comments
            ]
        );
    }

    /**
     * Save a comment in database
     *
     * @param int         $article_id Article ID
     * @param Utilisateur $auteur     Auteur
     * @param string      $contenu    Contenu
     */
    public function save($article_id, $auteur, $contenu)
    {
        $articleRepo = $this->entityManager->getRepository(Article::class);
        $article = $articleRepo->find($article_id);

        $auteurRepo = $this->entityManager->getRepository(Utilisateur::class);
        $auteur = $auteurRepo->find($auteur->getId());

        try {
            $commentaire = new Commentaire();
            $commentaire->hydrate($contenu);
            $commentaire->setArticle($article);
            $commentaire->setAuteur($auteur);

            $this->entityManager->persist($commentaire);
            $this->entityManager->flush();
            $this->flashMessage->success('Commentaire ajouté');

            return $this->redirect('/read/' . $article->getSlug());
        } catch (\Exception $e) {
            $this->flashMessage->error(self::ERR_ADD);
            return $this->redirect('/read/' . $article->getslug());
        }
    }

    /**
     * Set a comment as valid
     *
     * @param string $commentaire_id Commentaire Id
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function setValide($commentaire_id)
    {
        $commentRepo = $this->entityManager->getRepository(Commentaire::class);
        $comment = $commentRepo->find($commentaire_id);

        $comment->setValide(true);

        $this->entityManager->flush();

        $this->flashMessage->success('Commentaire validé');

        return $this->redirect('/admin/comments');
    }

    /**
     * Set a comment as invalid
     *
     * @param string $commentaire_id Commentaire Id
     */
    public function setInvalide($commentaire_id)
    {
        $commentRepo = $this->entityManager->getRepository(Commentaire::class);
        $comment = $commentRepo->find($commentaire_id);

        try {
            $comment->setValide(false);

            $this->entityManager->flush();

            $this->flashMessage->success('Commentaire invalidé');

            return $this->redirect('/admin/comments');
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            $this->flashMessage->error(self::ERR_GENERIC . $msg);
            return $this->redirect('/admin/comments');
        }
    }


    /**
     * Delete a comment
     *
     * @param string $commentaire_id Commentaire ID
     *
     * @return void
     */
    public function delete($commentaire_id, $token)
    {
        $commentRepo = $this->entityManager->getRepository(Commentaire::class);
        $comment = $commentRepo->find($commentaire_id);

        if ($token !== $this->CrsfToken)
        {
            die();
        }

        try {
            $this->entityManager->remove($comment);
            $this->entityManager->flush();

            $this->flashMessage->success('commentaire supprimé');

            return $this->redirect("/admin/comments");
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            $this->flashMessage->error(self::ERR_GENERIC . $msg);
            return $this->redirect('/admin/comments');
        }
    }
}
