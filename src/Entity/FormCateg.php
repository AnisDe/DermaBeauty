<?php

namespace App\Entity;

use App\Repository\FormCategRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FormCategRepository::class)
 */
class FormCateg
{

    /**
     * @ORM\Id
     * @Assert\Positive (message="l'identifiant doit etre positive")
     * @Assert\NotBlank(message="l'id est obligatoire")
     * @ORM\Column(type="integer")
     *
     */
    private $id_cat;

    /**
     * @Assert\Length (min=3,minMessage="ce champs doit avoire une chaine de caractere de taille supperieur a 2")
     * @Assert\NotBlank(message="le nom est obligatoire")
     *
     * @ORM\Column(type="string", length=255)
     *
     *
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(pattern="/^[a-z]+$/i", message="ce champs n'accepte pas les entiers")
     * @Assert\NotBlank(message="le type est obligatoire")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Formulaire::class, mappedBy="FormCateg", cascade="remove")
     */
    private $formulaire;

    public function __construct()
    {
        $this->formulaire = new ArrayCollection();
    }





    public function getIdCat(): ?int
    {
        return $this->id_cat;
    }

    public function setIdCat(int $id_cat): self
    {
        $this->id_cat = $id_cat;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Formulaire[]
     */
    public function getFormulaire(): Collection
    {
        return $this->formulaire;
    }

    public function addFormulaire(Formulaire $formulaire): self
    {
        if (!$this->formulaire->contains($formulaire)) {
            $this->formulaire[] = $formulaire;
            $formulaire->setFormCateg($this);
        }

        return $this;
    }

    public function removeFormulaire(Formulaire $formulaire): self
    {
        if ($this->formulaire->removeElement($formulaire)) {
            // set the owning side to null (unless already changed)
            if ($formulaire->getFormCateg() === $this) {
                $formulaire->setFormCateg(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return (string)$this->getNom();
    }

}
