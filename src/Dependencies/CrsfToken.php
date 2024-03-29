<?php

namespace Blog\Dependencies;

/**
 * Class CrsfToken
 *
 * Implement CRSF protection
 *
 * @package Blog\Dependencies
 */
class CrsfToken
{
    /**
     * @var string
     */
    public $token;

    /**
     * CrsfToken constructor.
     */
    public function __construct()
    {
        if (!isset($this->token)) {
            $this->token = md5(bin2hex(openssl_random_pseudo_bytes(6)));
        }
    }

    /**
     * Store the CrsfToken into the session
     *
     * @return string
     */
    public function store()
    {
        if (!isset($_SESSION['token'])) {
            $_SESSION['token'] =  $this->token;
        }

        return self::class;
    }

    /**
     * Return the CRSF token
     *
     * @return string
     */
    public function get()
    {
        return $this->token;
    }

    /**
     * Return stored Token
     *
     * @return string
     * @return null
     */
    public function getStoredToken()
    {
        if ($this->isStored()) {
            return $_SESSION['token'];
        }

        return null;
    }

    /**
     * Unset the Token session
     */
    public function destroy()
    {
        unset($_SESSION['token']);
    }

    /**
     * Check if the Token session exists
     *
     * @return bool
     */
    public function isStored()
    {
        if (isset($_SESSION['token'])) {
            return true;
        }

        return false;
    }
}
