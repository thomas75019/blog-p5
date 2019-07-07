<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity Commentaire
 *
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
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     */
    protected $auteur;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class)
     */
    protected $article;

    /**
     * Commentaire constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * @param int  $id
     */
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
    public function isValide()
    {
        return $this->valide;
    }


    /**
     * @param bool $valide Valide
     */
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


    /**
     * @param \DateTime $date Date
     */
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


    /**
     * @param string $contenu Contenu
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    /**
     * @param object $auteur Auteur
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;
    }

    /**
     * @return Utilisateur
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * @param object $article Article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }

    /**
     * @param array $data Data
     */
    public function hydrate($data)
    {
        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}
