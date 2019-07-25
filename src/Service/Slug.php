<?php

namespace Blog\Service;

/**
 * Class Slug
 *
 * Create a slug
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
    public function slugger($titre)
    {
        return str_replace(' ', '-', $titre);
    }
}
