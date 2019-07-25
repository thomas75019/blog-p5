<?php

namespace Blog\Service;

/**
 * Class Chapo
 *
 * Create a Chapo
 *
 * @package Blog\Service
 */
class Chapo
{
    /**
     * @param string $contenu Contenu
     *
     * @return string
     */
    public function createChapo($contenu)
    {
        $sanitizedConetnu = preg_replace('/<\/?[a-z0-9]+>/', '', $contenu);

        $chapo = substr(html_entity_decode($sanitizedConetnu), 0, 150);

        return $chapo . '...';
    }
}
