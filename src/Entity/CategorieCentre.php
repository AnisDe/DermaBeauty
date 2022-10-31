<?php

namespace App\Entity;

use App\Repository\CategorieCentreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieCentreRepository::class)
 */
class CategorieCentre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $specialite;



    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\ManyToMany(targetEntity=Centre::class, mappedBy="categorie" , cascade={"all"}, orphanRemoval=true)
     */
    private $centres;

    public function __construct()
    {
        $this->centres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }


    /**
     * @return Collection|Centre[]
     */
    public function getCentres(): Collection
    {
        return $this->centres;
    }

    public function addCentre(Centre $centre): self
    {
        if (!$this->centres->contains($centre)) {
            $this->centres[] = $centre;
            $centre->addCategorie($this);
        }

        return $this;
    }

    public function removeCentre(Centre $centre): self
    {
        if ($this->centres->removeElement($centre)) {
            $centre->removeCategorie($this);
        }

        return $this;
    }


    public function __toString() {
        return (string) $this->getType();
    }
}
