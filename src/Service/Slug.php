<?php
/**
 * Class Slug
 *
 * @see \Blog\Entity\Article::hydrate()
 */

namespace Blog\Service;

/**
 * Class Slug
 *
 * @package Blog\Service
 */
class Slug
{
    /**
     * Creates slug
     *
     * @param string $titre Titre
     *
     * @return string
     */
    public static function slugger($titre)
    {
        return str_replace(' ', '-', $titre);
    }
}
