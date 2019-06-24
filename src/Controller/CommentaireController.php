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
     * @param $article_id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getAll($article_id)
    {
        $commentaires = $this->entityManager->getRepository(Commentaire::class)->findAll();

        return $this->twig->render('back/viewAll.html.twig', [
            'commentaires' => $commentaires
        ]);
    }

    /**
     * @param $slug_article
     * @param $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save($article_id, $auteur, $contenu)
    {
        //TODO : Create forms
        $article = $this->entityManager->getRepository(Article::class)->find($article_id);
        $auteurComment = $this->entityManager->getRepository(Utilisateur::class)->find($auteur->getId());

        $commentaire = new Commentaire();
        $commentaire->hydrate($contenu);
        $commentaire->setArticle($article);
        $commentaire->setAuteur($auteurComment);

        $this->entityManager->persist($commentaire);
        $this->entityManager->flush();

        return $this->redirect('/read/' . $article->getSlug());
    }

    /**
     * @param $id_commentaire
     * @throws \Doctrine\ORM\ORMException
     */
    public function setValide($id_commentaire)
    {
        $commentaireRepo = $this->entityManager->getRepository(Commentaire::class);
        $commentaire = $commentaireRepo->find($id_commentaire);

        $commentaire->setValide(true);

        $this->entityManager->persist($commentaire);
    }


    /**
     * @param $id
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete($id)
    {
        $commentaireRepo = $this->entityManager->getRepository(Commentaire::class);

        $commentaire = $commentaireRepo->find($id);

        $this->entityManager->remove($commentaire);
        $this->entityManager->flush();
    }
}
