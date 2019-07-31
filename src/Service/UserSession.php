<?php

namespace Blog\Service;

/**
 * Class UserSession
 *
 * Instanciate and manage session for user
 *
 * @package Blog\Service
 */
class UserSession
{
    /**
     * Start a session
     *
     * @return void
     */
    public function start()
    {
        session_start();
    }

    /**
     * @param object $user Utilisateur
     */
    public function set($user)
    {
        $_SESSION['user'] = serialize($user);
    }

    /**
     * @return mixed|null
     */
    public function get()
    {
        if (!isset($_SESSION['user'])) {
            return null;
        }

        return unserialize($_SESSION['user']);
    }

    public function isStored()
    {
        if (isset($_SESSION['user'])) {
            return true;
        }

        return false;
    }

    /**
     * Unset User session
     */
    public function destroy()
    {
        unset($_SESSION['user']);
    }
}
