<?php
/**
 * Created by PhpStorm.
 * User: thomaslarousse
 * Date: 06/06/2019
 * Time: 20:34
 */

use Blog\Entity\Article;
use Blog\Entity\Commentaire;
use Blog\DoctrineLoader;

class CommentaireController extends DoctrineLoader
{
    /**
     * @param $slug_article
     * @param $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save($slug_article, $user)
    {
        //TODO : Create forms
        $article = $this->entityManager->getRepository(Article::class)->findBy([
            'slug' => $slug_article
        ]);


        $commentaire = new Commentaire();
        $commentaire->setAuteur($user);
        $commentaire->setArticle($article);

        $this->entityManager->persist($commentaire);
        $this->entityManager->flush();
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
     * @param $article_id
     * @return array|object[]
     */
    public function getValide($article_id)
    {
        $commentaireRepo = $this->entityManager->getRepository(Commentaire::class);

        $commentaires = $commentaireRepo->findBy([
            'valide' => true,
            'article' => $article_id
            ]);

        return $commentaires;
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