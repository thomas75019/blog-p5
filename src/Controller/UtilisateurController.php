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
     * Access to the login page
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function loginPage()
    {
        echo $this->twig->render('/forms/login.html.twig');
    }

    /**
     * Log in the user
     * @param $data array
     */
    public function login($data)
    {
        $user = $this->entityManager->getRepository(Utilisateur::class)->findOneBy([
            'pseudo' => $data['pseudo']
        ]);

        if (password_verify($data['motDePasse'], $user->getMotDePasse()))
        {
            session_start();
            $_SESSION['user'] = serialize($user);
            header('location: /');
        }
        else
        {
            throw new \RuntimeException('Wrong password or pseudo');
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