<?php
/**
 * Created by PhpStorm.
 * User: thomaslarousse
 * Date: 06/06/2019
 * Time: 20:34
 */

namespace Blog\Controller;

use Blog\Entity\Article;
use Blog\Entity\Commentaire;
use Blog\DoctrineLoader;
use Blog\Entity\Utilisateur;

class CommentaireController extends DoctrineLoader
{

    /**
     * @return string
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
     * @param $article_id
     * @param $auteur
     * @param $contenu
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save($article_id, $auteur, $contenu)
    {
        $article = $this->entityManager->getRepository(Article::class)->find($article_id);
        $auteurComment = $this->entityManager->getRepository(Utilisateur::class)->find($auteur->getId());

        $commentaire = new Commentaire();
        $commentaire->hydrate($contenu);
        $commentaire->setArticle($article);
        $commentaire->setAuteur($auteurComment);

        $this->entityManager->persist($commentaire);
        $this->entityManager->flush();
        $this->flashMessage->success('Commentaire ajouté');

        return $this->redirect('/read/' . $article->getSlug());
    }

    /**
     * @param string $commentaire_id
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
     * @param string $commentaire_id
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function setInvalide($commentaire_id)
    {
        $commentaire = $this->entityManager->getRepository(Commentaire::class)->find($commentaire_id);

        $commentaire->setValide(false);

        $this->entityManager->flush();

        $this->flashMessage->success('Commentaire invalidé');

        return $this->redirect('/admin/comments');
    }


    /**
     * @param string $commentaire_id
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete($commentaire_id)
    {
        $commentaire = $this->entityManager->getRepository(Commentaire::class)->find($commentaire_id);

        $this->entityManager->remove($commentaire);
        $this->entityManager->flush();

        $this->flashMessage->success('commentaire invalidé');

        return $this->redirect("/admin/comments");
    }
}
