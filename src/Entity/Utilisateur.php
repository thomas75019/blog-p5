<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;

/**
 * Entity Utilisateur
 *
 * @ORM\Entity
 * @ORM\Table(name="utilisateur", uniqueConstraints={@UniqueConstraint(name="user_idx", columns={"email", "pseudo"})})
 */
class Utilisateur
{
    const ADMIN = 1;

    const UTILISATEUR = 0;

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
     * @ORM\Column(type="integer")
     */
    protected $type;

    /**
     * @ORM\OneToMany(targetEntity="Article", mappedBy="articles")
     */
    protected $articles;

    /**
     * Utilisateur constructor.
     */
    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->type = self::UTILISATEUR;
    }


    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id Id
     */
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

    /**
     * @param string $email Email
     */
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

    /**
     * @param string $mot_de_passe MotDePasse
     */
    public function setMotDePasse($mot_de_passe)
    {
        $this->mot_de_passe = $mot_de_passe;
    }

    /**
     * @param string $pseudo Pseudo
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * set user type
     *
     * @param self $type Type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Hydrate the object
     *
     * @param array $data Data
     *
     * @return void
     */
    public function hydrate($data)
    {
        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);

            if ($key === 'motDePasse') {
                $this->setMotDePasse(password_hash($value, PASSWORD_BCRYPT));
            } elseif (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * Check if user is Admin
     *
     * @return bool
     */
    public function isAdmin()
    {
        if ($this->type === self::UTILISATEUR) {
            return false;
        }

        return true;
    }
}
