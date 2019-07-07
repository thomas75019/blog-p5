<?php

namespace Blog\Service;

class Chapo
{
    /**
     * @param string $contenu Contenu
     *
     * @return string
     */
    public function createChapo($contenu)
    {
        $chapo = substr($contenu, 0, 150);

        return $chapo . '...';
    }
}
