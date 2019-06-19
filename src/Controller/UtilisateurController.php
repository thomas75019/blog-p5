<?php

namespace Blog\Controller;


use Blog\DoctrineLoader;
use Blog\Entity\TypeUtilisateur;
use Blog\Entity\Utilisateur;

class UtilisateurController extends DoctrineLoader
{
    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function register()
    {
        echo $this->twig->render('forms/register.html.twig');
    }

    /**
     * Create a user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createUser($data)
    {
        $em = $this->entityManager;
        $user = new Utilisateur();
        //$type = $this->entityManager->getRepository(TypeUtilisateur::class)->find(1);

        $user->hydrate($data);
        $user->setType(null);

        $em->persist($user);
        $em->flush();
    }

    /**
     * Delete a user
     * @param $user_id integer
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete($user_id)
    {
        $user = $this->entityManager->getRepository(Utilisateur::class)->find($user_id);

        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    /**
     * Login
     * @param $pseudo string
     * @param $password string
     */
    public function login($pseudo, $password)
    {
        $user = $this->entityManager->getRepository(Utilisateur::class)->findBy([
            'pseudo' => $pseudo
        ]);

        if (password_verify($password, $user->getMotDePasse()))
        {
            session_start();
            $_SESSION['user'] = serialize($user);
        }
        else
        {
            throw new \RuntimeException('Wrong password');
        }
    }

    /**
     *Logout the user and redirect to homepage
     */
    public function logout()
    {
        session_destroy();
        header('Location: /');
    }
}