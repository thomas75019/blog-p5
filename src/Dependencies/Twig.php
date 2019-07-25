<?php

namespace Blog\Dependencies;

use Blog\Service\UserSession;
use Plasticbrain\FlashMessages\FlashMessages;
use Twig\Loader\FilesystemLoader;

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

    public $token;

    public $flash;

    /**
     * Twig constructor.
     *
     * @param UserSession $session UserSession injection
     */
    public function __construct(UserSession $session)
    {
        $this->loader = new FilesystemLoader('/Users/thomaslarousse/Desktop/Projet5/src/View');

        $this->twig = new \Twig\Environment(
            $this->loader,
            [
            'cache' => false
            ]
        );

        $this->token = new CrsfToken();

        if ($session->isStored()) {
            $this->twig->addGlobal('user', $session->get());
        }

        if ($this->token->isStored()) {
            $this->twig->addGlobal('token', $this->token->getStoredToken());
        }

        /*$this->flash = $_SESSION['flash_messages'];
        if (isset($this->flash))
        {
            $this->twig->addGlobal('message', [$this->flash['message']]);
        }*/
    }

    /**
     * @return \Twig\Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }
}
