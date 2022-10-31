<?php

namespace App\Entity;

use App\Repository\CategoriePRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoriePRepository::class)
 */
class CategorieP
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champs obligatoir")
     */
    private $Reference_C;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champs obligatoir")
     */
    private $Nom_C;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="Categorie", cascade={"remove"})
     */
    private $produits;


    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getReferenceC(): ?string
    {
        return $this->Reference_C;
    }

    public function setReferenceC(string $Reference_C): self
    {
        $this->Reference_C = $Reference_C;

        return $this;
    }

    public function getNomC(): ?string
    {
        return $this->Nom_C;
    }

    public function setNomC(string $Nom_C): self
    {
        $this->Nom_C = $Nom_C;

        return $this;
    }


    /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setCategorieP($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getCategorieP() === $this) {
                $produit->setCategorieP(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return (string)$this->getNomC();

    }
}
