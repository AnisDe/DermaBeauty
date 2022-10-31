<?php

namespace App\Entity;

use App\Repository\CategorieDermRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategorieDermRepository::class)
 */
class CategorieDerm
{



    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @Assert\Positive
     * @Assert\NotBlank (message="please enter your reference ")
     */
    private $ref;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank (message="please enter your localisation ")
     */
    private $localisation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank (message="please enter the Name of category  ")
     *  @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "^[a-zA-Z]+$",
     *     message="Do not use number"
     * )
     */
    private $nomCat;

    /**
     * @ORM\OneToMany(targetEntity=Dermatologue::class, mappedBy="categorie" , cascade={"remove"})
     */
    private $dermatologues;

    public function __construct()
    {
        $this->dermatologues = new ArrayCollection();
    }





    public function getRef(): ?int
    {
        return $this->ref;
    }

    public function setRef(int $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getNomCat(): ?string
    {
        return $this->nomCat;
    }

    public function setNomCat(string $nomCat): self
    {
        $this->nomCat = $nomCat;

        return $this;
    }

    /**
     * @return Collection|Dermatologue[]
     */
    public function getDermatologues(): Collection
    {
        return $this->dermatologues;
    }

    public function addDermatologue(Dermatologue $dermatologue): self
    {
        if (!$this->dermatologues->contains($dermatologue)) {
            $this->dermatologues[] = $dermatologue;
            $dermatologue->setCategorie($this);
        }

        return $this;
    }

    public function removeDermatologue(Dermatologue $dermatologue): self
    {
        if ($this->dermatologues->removeElement($dermatologue)) {
            // set the owning side to null (unless already changed)
            if ($dermatologue->getCategorie() === $this) {
                $dermatologue->setCategorie(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        return (string)$this->getLocalisation();

    }

}
