<?php
/**
 * Set up and configure Doctrine and ent EntityManager
 */
namespace Blog\Dependencies;

use Blog\Config\DbConfig;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * Class Doctrine
 *
 * Set up doctrine and entity manager
 *
 * @package Blog\Dependencies
 */
class Doctrine
{
    /**
     * @var array
     */
    private $_entitiesPath = [__DIR__ . '../Entity'];

    /**
     * @var bool
     */
    private $_isDevMode = true;

    /**
     * @var null
     */
    private $_proxyDir = null;

    /**
     * @var null
     */
    private $_cache = null;

    /**
     * @var bool
     */
    private $_useSimpleAnnotationReader = false;

    /**
     * @var array
     */
    private $_params;

    /**
     * @var \Doctrine\ORM\Configuration
     */
    private $_config;

    /**
     * @var EntityManager
     */
    public $entityManager;

    /**
     * @var DbConfig
     */
    public $config;

    /**
     * Doctrine constructor.
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function __construct()
    {
        if (!isset($this->config)) {
            $this->config = new DbConfig();
        }

        $this->_params = $this->config->DbInfo();

        $this->_config = Setup::createAnnotationMetadataConfiguration(
            $this->_entitiesPath,
            $this->_isDevMode,
            $this->_proxyDir,
            $this->_cache,
            $this->_useSimpleAnnotationReader
        );

        $this->entityManager = EntityManager::create($this->_params, $this->_config);
    }

    /**
     * @return EntityManager
     */
    public function getEm()
    {
        return $this->entityManager;
    }
}
