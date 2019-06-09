<?php
/**
 * Created by PhpStorm.
 * User: thomaslarousse
 * Date: 06/06/2019
 * Time: 20:34
 */

use Blog\Entity\Article;
use Blog\Entity\Commentaire;

class CommentaireController extends \Blog\DoctrineLoader
{
    public function create ($slug_article, $user)
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

    public function setValide($id_commentaire)
    {
        $commentaireRepo = $this->entityManager->getRepository(Commentaire::class);
        $commentaire = $commentaireRepo->find($id_commentaire);

        $commentaire->setValide(true);

        $this->entityManager->persist($commentaire);
    }

    public function getValide($article_id)
    {
        $commentaireRepo = $this->entityManager->getRepository(Commentaire::class);

        $commentaires = $commentaireRepo->findBy([
            'valide' => true,
            'article' => $article_id
            ]);

        return $commentaires;
    }

    public function delete($id)
    {
        $commentaireRepo = $this->entityManager->getRepository(Commentaire::class);

        $commentaire = $commentaireRepo->find($id);

        $this->entityManager->remove($commentaire);
        $this->entityManager->flush();
    }
}