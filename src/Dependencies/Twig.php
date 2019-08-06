<?php

namespace Blog\Dependencies;

use Blog\Service\UserSession;
use Blog\Dependencies\FlashMessage;
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
    private $loader;

    /**
     * @var \Twig\Environment
     */
    public $twig;

    /**
     * @var CrsfToken
     */
    public $token;


    /**
     * @var FlashMessages
     */
    public $flash;

    /**
     * Twig constructor.
     *
     * @param UserSession $session UserSession injection
     */
    public function __construct(UserSession $session)
    {
        $this->loader = new FilesystemLoader('src/View');

        $this->twig = new \Twig\Environment(
            $this->loader,
            [
            'cache' => false
            ]
        );

        $this->token = new CrsfToken();

        $this->flash = new FlashMessages();

        if ($session->isStored()) {
            $this->twig->addGlobal('user', $session->get());
        }

        if ($this->token->isStored()) {
            $this->twig->addGlobal('token', $this->token->getStoredToken());
        }

        $this->flash->display();
    }

    /**
     * Get Twig object
     *
     * @return \Twig\Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }
}
