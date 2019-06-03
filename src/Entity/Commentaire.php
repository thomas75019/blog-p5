<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="commentaires")
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     */
    protected $contenu;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $valide = false;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     */
    protected $auteur;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class)
     */
    protected $article;

    public function __construct()
    {
        $this->datetime = new \DateTime();
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function getValide()
    {
        return $this->valide;
    }


    public function setValide($valide)
    {
        $this->valide = $valide;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }


    public function setDate($date)
    {
        $this->date = $date;
    }


    /**
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }


    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    public function getAuteur()
    {
        return $this->auteur;
    }

}