<?php


namespace Blog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Blog\Service\Slug;
use Blog\Service\Chapo;

/**
 * Entity Article
 *
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
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $titre;

    /**
     * @ORM\Column(type="string")
     */
    public $chapo;

    /**
     * @ORM\Column(type="text")
     */
    public $contenu;

    /**
     * @ORM\Column(type="string")
     */
    public $slug;

    /**
     * @ORM\Column(type="datetime")
     */
    public $date;

    /**
     * @ORM\ManyToOne(targetEntity="Utilisateur", cascade={"persist"})
     */
    public $auteur;

    /**
     * @ORM\OneToMany(targetEntity="Commentaire", mappedBy="contenu", cascade={"remove"})
     */
    public $commentaires;


    /**
     * Article constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime();
        $this->commentaires = new ArrayCollection();
    }

    /**
     * @param $id integer Id
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
     * @param string $titre Titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $chapo Chapo
     */
    public function setChapo($chapo)
    {
        $this->chapo = $chapo;
    }

    /**
     * @return string
     */
    public function getChapo()
    {
        return $this->chapo;
    }

    /**
     * @param string $slug Slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return ArrayCollection
     */
    public function getCommentaires()
    {
        return $this->commentaires;
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
     * @param array $data Data
     */
    public function hydrate($data)
    {
        $titre = $data['titre'];
        $contenu = $data['contenu'];

        $this->setChapo(Chapo::createChapo($contenu));
        $this->setSlug(Slug::Slugger($titre));

        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}
