<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="types_utilisateur")
 */
class TypeUtilisateur
{
    /**
     * @ORM\Id
     * @ORM\Column(name="type", type="string")
     */
    protected $type;


    public function getType()
    {
        return $this->type;
    }


    public function setType($type)
    {
        $this->type = $type;
    }


}