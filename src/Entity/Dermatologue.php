<?php

namespace App\Entity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Repository\DermatologueRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Table(name="dermatologue")
 * @ORM\Entity(repositoryClass=DermatologueRepository::class)
 *
 *
 */
class Dermatologue extends User
{


   /*
    /**
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Please enter your identifier")
     * @Assert\Length(
     *     min=8,
     *
     *    maxMessage = "Your cin cannot be longer than {{ limit }} characters"
     * )
     * @@Assert\Positive
     */
/*    private $cin;*/
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;
    /**
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please enter your diploma")
     */
    private $diplome;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please enter your formation")
     */
    private $formation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please make a choice")
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please make a choice")
     */
    private $horaire;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please make a choice")
     */
    private $modereglement ;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please make a choice")
     */
    private $assurancemaladie;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please upload image")
     * @Assert\File(mimeTypes={"image/jpeg"})
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieDerm::class, inversedBy="dermatologues" )
     * @ORM\JoinColumn(nullable=false ,name="categorie", referencedColumnName="ref")
     */
    private $categorie;




    public function getId(): ?int
    {
        return parent::getId();
    }

        public function getDiplome(): ?string
    {
        return $this->diplome;
    }

    public function setDiplome(string $diplome): self
    {
        $this->diplome = $diplome;

        return $this;
    }

    public function getFormation(): ?string
    {
        return $this->formation;
    }

    public function setFormation(string $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getHoraire(): ?string
    {
        return $this->horaire;
    }

    public function setHoraire(string $horaire): self
    {
        $this->horaire = $horaire;

        return $this;
    }

    public function getModereglement()
    {
        return $this->modereglement;
        //$modereglemen[] = 'Cheque';
        //return array_unique($modereglemen);

    }

    public function setModereglement( string $modereglement)
    {
        $this->modereglement  = $modereglement;

        return $this;
    }

    public function getAssurancemaladie(): ?string
    {
        return $this->assurancemaladie;
    }

    public function setAssurancemaladie(string $assurancemaladie): self
    {
        $this->assurancemaladie = $assurancemaladie;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage( $image)
    {
        $this->image = $image;

        return $this;
    }

    public function getCategorie(): ?CategorieDerm
    {
        return $this->categorie;
    }

    public function setCategorie(?CategorieDerm $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
    /*
    /** @see \Serializable::serialize() */
/*public function serialize()
{
    return serialize(array(
        $this->modereglement,

    ));
}

    /** @see \Serializable::unserialize() */
  /*  public function unserialize($serialized)
    {
        list (
            $this->modereglement,

            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }
*/


}
