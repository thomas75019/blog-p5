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
     * Create an user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createUser($data)
    {
        $em = $this->entityManager;
        $user = new Utilisateur();

        $user->hydrate($data);
        $user->setType(null);

        $em->persist($user);
        $em->flush();
    }

    /**
     * Delete an user
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
     * @param $data array
     * @return mixed
     */
    public function login($data)
    {
        if (!isset($_SESSION['user'])) {
            $user = $this->entityManager->getRepository(Utilisateur::class)->findOneBy([
                'pseudo' => $data['pseudo']
            ]);

            if (password_verify($data['motDePasse'], $user->getMotDePasse())) {
                //Avoid that password being stored in session
                $user->setMotDePasse(null);
                $_SESSION['user'] = serialize($user);
                $this->flashMessage->success('Bienvenue, ' . $user->getPseudo());
                return $this->redirect('/');
            } else {
                $this->flashMessage->error('Mauvais pseudo ou mot de passe');
                $this->redirect('/login');
            }
        }

        return $this->redirect('/');
    }

    /**
     *Logout the user and redirect to homepage
     */
    public function logout()
    {
        if (isset($_SESSION['user'])) {
            session_destroy();
            return $this->redirect('/');
        }

        return $this->redirect('/');
    }
}
