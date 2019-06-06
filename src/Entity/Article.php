<?php


namespace Blog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class Article
 * @ORM\Entity
 * @ORM\Table(name="articles", indexes={@ORM\Index(name="article_idx", columns={"titre", "slug"})})
 */
class Article
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
    protected $titre;

    /**
     * @ORM\Column(type="string")
     */
    protected $chapo;

    /**
     * @ORM\Column(type="text")
     */
    protected $contenu;

    /**
     * @ORM\Column(type="string")
     */
    protected $slug;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     */
    protected $auteur;

    /**
     * @ORM\OneToMany(targetEntity="Commentaire", mappedBy="commentaires", cascade={"persist", "remove"})
     */
    protected $commentaires;



    public function __construct()
    {
        $this->date = new \DateTime();
        $this->commentaires = new ArrayCollection();

    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    public function setChapo($chapo)
    {
        $this->chapo = $chapo;
    }

    public function getChapo()
    {
        return $this->chapo;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getCommentaires()
    {
        return $this->commentaires;
    }

    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;
    }
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * @return mixed
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * @param mixed $contenu
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }



}