<?php
/**
 * Class Chapo
 *
 * Creates a chapo
 *
 * @package Blog\Service
 *
 * @see \Blog\Entity\Article::hydrate()
 */

namespace Blog\Service;

/**
 * Class Chapo
 *
 * Creates a chapo
 *
 * @package Blog\Service
 */
class Chapo
{
    /**
     * @param string  $contenu
     *
     * @return string
     */
    public static function createChapo($contenu)
    {
        $chapo = substr($contenu, 0, 150);

        return $chapo . '...';
    }
}
