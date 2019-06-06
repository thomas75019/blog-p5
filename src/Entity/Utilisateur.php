<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Utilisateur
 * @ORM\Entity
 * @ORM\Table(name="utilisateur", indexes={@ORM\Index(name="user_idx", columns={"email", "pseudo"})})
 */
class Utilisateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $pseudo;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $mot_de_passe;

    /**
     * @ORM\OneToOne(targetEntity="TypeUtilisateur")
     * @ORM\JoinColumn(name="type", referencedColumnName="type")
     */
    protected $type;

    /**
     *@ORM\OneToMany(targetEntity="Article", mappedBy="articles")
     */
    protected $articles;



    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }


    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }


    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getMotDePasse()
    {
        return $this->mot_de_passe;
    }


    public function setMotDePasse($mot_de_passe)
    {
        $this->mot_de_passe = $mot_de_passe;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @var string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }


}