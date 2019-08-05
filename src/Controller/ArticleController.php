<?php

namespace Blog\Controller;

use Blog\Controller\Controller;
use Blog\Dependencies\CrsfToken;
use Blog\Dependencies\Doctrine;
use Blog\Dependencies\FlashMessage;
use Blog\Dependencies\Twig;
use Blog\Entity\Article;
use Blog\Entity\Commentaire;
use Blog\Entity\Utilisateur;
use Blog\Service\Chapo;
use Blog\Service\Slug;

class ArticleController extends Controller
{
    const ERR_ADD = 'Erreur dans l\'ajout de l\'article :';

    const ERR_DEL = 'Erreur lors de la mise à jour de l\'article: ';

    const ERR_UPDATE = 'Erreur lors de la suppression de l\'article: ';

    /**
     * @var string Chapo
     */
    public $chapo;

    /**
     * @var string Slug
     */
    public $slugger;

    /**
     * ArticleController constructor.
     *
     * @param Twig $twig
     * @param Doctrine $entityManager
     * @param FlashMessage $flash
     * @param CrsfToken $token
     */
    public function __construct(
        Twig $twig,
        Doctrine $entityManager,
        FlashMessage $flash,
        CrsfToken $token
    ) {
        parent::__construct($twig, $entityManager, $flash, $token);
        $this->chapo = new Chapo();
        $this->slugger = new Slug();
    }


    /**
     * Get all articles
     *
     * @return array|object[]
     */
    public function getAll()
    {
        $articles = $this->entityManager->getRepository(Article::class)
            ->findBy([], ['date' => 'DESC']);


        return $articles;
    }

    /**
     * Render the page with all articles
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getListAdmin()
    {
        echo $this->twig->render(
            'back/articles.html.twig',
            [
                'articles' => $this->getAll()
            ]
        );
    }

    /**
     * render list of articles page
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getListFront()
    {
        echo $this->twig->render(
            'front/index.html.twig',
            [
                'articles' => $this->getAll()
            ]
        );
    }

    /**
     * Render a single article page
     *
     * @param string $slug Slug
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getOneBySlug($slug)
    {
        $articleRepo = $this->entityManager->getRepository(Article::class);
        $article = $articleRepo->findOneBy(
            [
                'slug' => $slug
            ]
        );

        $commentaireRepo = $this->entityManager->getRepository(Commentaire::class);
        $commentaires = $commentaireRepo->findBy(
            [
                'article' => $article,
                'valide' => true
            ]
        );

        echo $this->twig->render(
            'front/viewOne.html.twig',
            [
                'article' => $article,
                'commentaires' => $commentaires
            ]
        );
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
     * @param array       $data Data
     * @param Utilisateur $user Auteur
     */
    public function save($data, $user)
    {
        $auteurRepo = $this->entityManager->getRepository(Utilisateur::class);
        $auteur = $auteurRepo->find($user->getId());

        try {
            $article = new Article();

            $article->hydrate($data, new Slug(), new Chapo());
            $article->setAuteur($auteur);

            $this->entityManager->persist($article);
            $this->entityManager->flush();
            $this->flashMessage->success(
                'L\'article a bien été ajouté',
                '/list/article'
            );
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            $this->flashMessage->error(
                self::ERR_ADD . $msg,
                '/create/article'
            );
        }
    }

    /**
     * Render the update article page
     *
     * @param int $article_id Article Id
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
            'forms/updateArticle.html.twig',
            [
                'article' => $article
            ]
        );
    }

    /**
     * Save the updates
     *
     * @param array $data       Data
     * @param int   $article_id Article Id
     *
     * @return void
     */
    public function saveUpdate($data, $article_id)
    {
        $articleRepo = $this->entityManager->getRepository(Article::class);
        $article = $articleRepo->find($article_id);

        try {
            $article->hydrate($data, $this->slugger, $this->chapo);
            $this->entityManager->flush();
            $this->flashMessage->success(
                'L\'article a été mis à jour',
                '/read/' . $article->getSlug()
            );
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            $this->flashMessage->error(
                self::ERR_UPDATE . $msg,
                '/update/article'
            );
        }
    }

    /**
     * Remove the Article
     *
     * @param string $article_id Article ID
     * @param string $token      CRSF Token
     *
     * @throws \Exception
     * @return void
     */
    public function delete($article_id, $token)
    {
        $articleRepo = $this->entityManager->getRepository(Article::class);
        $article = $articleRepo->find($article_id);

        if ($token !== $this->CrsfToken) {
            throw new \Exception(
                'Something went wrong, please retry or try to reconnect'
            );
        }

        try {
            $this->entityManager->remove($article);
            $this->entityManager->flush();
            $this->flashMessage->success(
                'L\'article a bien été supprimé',
                '/list/article'
            );
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            $this->flashMessage->error(
                self::ERR_DEL . $msg,
                '/list/article'
            );
        }
    }
}
