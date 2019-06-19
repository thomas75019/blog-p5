<?php

namespace Blog\Service;


class Slug
{
    public static function Slugger($titre)
    {
        return str_replace(' ', '-', $titre);
    }
}