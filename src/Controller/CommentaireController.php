<?php
/**
 * Created by PhpStorm.
 * User: thomaslarousse
 * Date: 06/06/2019
 * Time: 20:34
 */

use Doctrine\ORM\EntityManager;
use Blog\Entity\Article;
use Blog\Entity\Commentaire;

class CommentaireController
{
    public function create(EntityManager $entityManager, $slug_article)
    {
        //TODO : Create forms
        $article = $entityManager->getRepository(Article::class)->findBy([
            'slug' => 'slug'
        ]);
        $id = $article->getId();

        $commentaire = new Commentaire();
        $commentaire->setAuteur($auteur);
    }
}