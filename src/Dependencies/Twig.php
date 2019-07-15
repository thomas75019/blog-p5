<?php

namespace Blog\Dependencies;

use Blog\Service\UserSession;


/**
 * Class Twig
 *
 * Set up twig and creates the method to get twig
 *
 * @package Blog\Dependencies
 */
class Twig
{
    /**
     * @var \Twig\Loader\FilesystemLoader
     */
    public $loader;

    /**
     * @var \Twig\Environment
     */
    public $twig;

    /**
     * Twig constructor.
     *
     * @param UserSession $session UserSession injection
     */
    public function __construct(UserSession $session)
    {
        $this->loader = new \Twig\Loader\FilesystemLoader('/Users/thomaslarousse/Desktop/Projet5/src/View');

        $this->twig = new \Twig\Environment($this->loader, [
            'cache' => false
        ]);

        if ($session->isStored()) {
            $this->twig->addGlobal('user', $session->get());
        }
    }

    /**
     * @return \Twig\Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }
}