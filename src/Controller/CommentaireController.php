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
     * Render the page with all comments
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getAll()
    {
        $commentRepo = $this->entityManager->getRepository(Commentaire::class);
        $comments = $commentRepo->findBy([], ['date' => 'DESC']);

        echo $this->twig->render(
            'back/viewAllComments.html.twig',
            [
                'commentaires' => $comments
            ]
        );
    }

    /**
     * Save a comment in database
     *
     * @param int         $article_id Article ID
     * @param Utilisateur $auteur     Auteur
     * @param array       Data        Datas
     */
    public function save($article_id, $auteur, $data)
    {
        $articleRepo = $this->entityManager->getRepository(Article::class);
        $article = $articleRepo->find($article_id);


        $auteurRepo = $this->entityManager->getRepository(Utilisateur::class);
        $auteur = $auteurRepo->find($auteur->getId());

        try {
            $commentaire = new Commentaire();
            $commentaire->hydrate($data);
            $commentaire->setArticle($article);
            $commentaire->setAuteur($auteur);

            $this->entityManager->persist($commentaire);
            $this->entityManager->flush();
            $this->flashMessage->success(
                'Commentaire ajouté',
                '/read/' . $article->getSlug()
            );
        } catch (\Exception $e) {
            $this->flashMessage->error(
                self::ERR_ADD,
                '/create/article'
            );
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

        $this->flashMessage->success(
            'Commentaire validé',
            '/list/comments'
        );
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

            $this->flashMessage->success(
                'Commentaire invalidé',
                '/list/comments'
            );
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            $this->flashMessage->error(
                self::ERR_GENERIC . $msg,
                '/list/comments'
            );
        }
    }


    /**
     * Delete a comment
     *
     * @param string $commentaire_id Commentaire ID
     * @param string $token          CrsfToken
     *
     * @throws \Exception
     * @return void
     */
    public function delete($commentaire_id, $token)
    {
        $commentRepo = $this->entityManager->getRepository(Commentaire::class);
        $comment = $commentRepo->find($commentaire_id);

        if ($token !== $this->CrsfToken) {
            throw new \Exception('Something went wrong, please retry or try to reconnect');
        }

        try {
            $this->entityManager->remove($comment);
            $this->entityManager->flush();

            $this->flashMessage->success(
                'commentaire supprimé',
                '/list/comments'
            );
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            $this->flashMessage->error(
                self::ERR_GENERIC . $msg,
                '/list/comments'
            );
        }
    }
}
