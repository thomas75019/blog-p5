<?php

namespace Blog\Controller;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Blog\Config\DbConfig;
use Plasticbrain\FlashMessages\FlashMessages;
use Blog\Service\Mail;

/**
 * Class Controller
 *
 * Load EntityManager and Twig
 * and s
 *
 * @package Blog
 */
class Controller
{
    const ERR_GENERIC = "Une erreur est apparu: ";

    /**
     * @var array
     */
    public $entitiesPath = [__DIR__ . '/Entity'];

    /**
     * @var bool
     */
    public $isDevMode = true;

    /**
     * @var null
     */
    public $proxyDir = null;

    /**
     * @var null
     */
    public $cache = null;

    /**
     * @var bool
     */
    public $useSimpleAnnotationReader = false;

    /**
     * @var array
     */
    public $params;

    /**
     * @var \Doctrine\ORM\Configuration
     */
    public $config;

    /**
     * @var EntityManager
     */
    public $entityManager;

    /**
     * @var \Twig\Loader\FilesystemLoader
     */
    protected $loader;

    /**
     * @var \Twig\Environment
     */
    protected $twig;

    protected $flashMessage;

    /**
     * Controller constructor.
     * @throws \Doctrine\ORM\ORMException
     */
    public function __construct()
    {
        $this->params = DbConfig::DbInfo();

        $this->config = Setup::createAnnotationMetadataConfiguration(
            $this->entitiesPath,
            $this->isDevMode,
            $this->proxyDir,
            $this->cache,
            $this->useSimpleAnnotationReader
        );

        $this->entityManager = EntityManager::create($this->params, $this->config);

        $this->loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/View');

        $this->twig = new \Twig\Environment($this->loader, [
            'cache' => false
        ]);

        if (isset($_SESSION['user'])) {
            $this->twig->addGlobal('user', unserialize($_SESSION['user']));
        }


        $this->flashMessage = new FlashMessages();

        if (isset($_SESSION['flash_messages'])) {
            $this->flashMessage->display();
        }
    }

    /**
     * @param string $url
     * @param int $statusCode
     */
    protected function redirect($url, $statusCode = 302)
    {
        header('Location: ' . $url, true, $statusCode);
        die();
    }
}
