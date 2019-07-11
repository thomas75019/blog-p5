<?php
/**
 * Set up and configure Doctrine and ent EntityManager
 */
namespace Blog\Dependencies;

use Blog\Config\DbConfig;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Doctrine
{
    /**
     * @var array
     */
    private $entitiesPath = [__DIR__ . '../Entity'];

    /**
     * @var bool
     */
    private $isDevMode = true;

    /**
     * @var null
     */
    private $proxyDir = null;

    /**
     * @var null
     */
    private $cache = null;

    /**
     * @var bool
     */
    private $useSimpleAnnotationReader = false;

    /**
     * @var array
     */
    private $params;

    /**
     * @var \Doctrine\ORM\Configuration
     */
    private $config;

    /**
     * @var EntityManager
     */
    public $entityManager;

    /**
     * Doctrine constructor.
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
    }

    /**
     * @return EntityManager
     */
    public function getEm()
    {
        return $this->entityManager;
    }
}