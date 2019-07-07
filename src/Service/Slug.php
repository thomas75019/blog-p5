<?php

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
     * @param string  $titre
     * @return string
     */
    public static function slugger($titre)
    {
        return str_replace(' ', '-', $titre);
    }
}
