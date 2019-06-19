<?php

namespace Blog\Service;

class Chapo
{
    public static function createChapo($contenu)
    {
        $chapo = substr($contenu, 0, 150);

        return $chapo . '...';
    }
}