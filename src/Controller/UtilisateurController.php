<?php

namespace Blog\Controller;

use Blog\Controller\Controller;
use Blog\Dependencies\CrsfToken;
use Blog\Entity\Utilisateur;
use Blog\Service\UserSession;


class UtilisateurController extends Controller
{
    /**
     * Render the register page
     *
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
     *
     * @param array $data Datas
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @return void
     */
    public function createUser($data)
    {
        $entityManager = $this->entityManager;
        $user = new Utilisateur();

        $user->hydrate($data);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirect('/');
    }

    /**
     * Delete an user
     *
     * @param int $user_id User Id
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete($user_id)
    {
        $userRepo = $this->entityManager->getRepository(Utilisateur::class);
        $user = $userRepo->find($user_id);

        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    /**
     * Render the login page
     *
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
     *
     * @param array       $data    Datas
     * @param UserSession $session User session object
     */
    public function login($data, UserSession $session)
    {
        $_SESSION['id'] = 0;
        if (!$session->isStored()) {
            $userRepo = $this->entityManager->getRepository(Utilisateur::class);
            $user = $userRepo->findOneBy(
                [
                    'pseudo' => $data['pseudo']
                ]
            );

            if (password_verify($data['motDePasse'], $user->getMotDePasse())) {
                //Avoid that password being stored in session
                $user->setMotDePasse(null);
                $session->set($user);

                if ($user->isAdmin())
                {
                    $token = new CrsfToken();
                    $token->store();
                }

                $_SESSION['id'] = 1;

                return $this->redirect('/');

                //$this->flashMessage->success('Bienvenue, ' . $user->getPseudo(), '/');
                //$this->flashMessage->display();


            }


            //$this->flashMessage->error('Mauvais pseudo ou mot de passe');
            $this->redirect('/login');
        }

        return $this->redirect('/');
    }

    /**
     * Logout the user and redirect to homepage
     *
     * @param UserSession $session Session object
     */
    public function logout(UserSession $session)
    {
        if ($session->isStored()) {
            $session->destroy();
            return $this->redirect('/');
        }

        return $this->redirect('/');
    }
}
