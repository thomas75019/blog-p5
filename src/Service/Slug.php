<?php
/**
 * Class Slug
 *
 * @see  \Blog\Entity\Article::hydrate()
 * @link undefined
 */

namespace Blog\Service;

/**
 * Class Slug
 *
 * @package Blog\Service
 *
 * @link undefined
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
