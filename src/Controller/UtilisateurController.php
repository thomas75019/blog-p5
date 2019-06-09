<?php

namespace Blog\Controller;


use Blog\DoctrineLoader;
use Blog\Entity\TypeUtilisateur;
use Blog\Entity\Utilisateur;

class UtilisateurController extends DoctrineLoader
{
    /**
     * Create a user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create()
    {
        $user = new Utilisateur();
        $type = $this->entityManager->getRepository(TypeUtilisateur::class)->findBy([
            'type' => 'admin'
        ]);

        $user->setPseudo('thomas');
        $user->setEmail('tlarousse3@gmail.com');
        $user->setType($type);
        $user->setPseudo('thomas');

        $this->entityManager->persist($user);
        $this->entityManager->flush();
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