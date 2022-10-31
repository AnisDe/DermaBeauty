<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champs obligatoir")
     */
    private $Reference_P;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champs obligatoir")
     */
    private $Nom_P;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champs obligatoir")
     */
    private $Type_P;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champs obligatoir")

     */
    private $Marque_P;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Champs obligatoir")
     */
    private $Prix_P;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank(message="Champs obligatoir")
     */
    private $Quantite_P;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champs obligatoir")
     */
    private $Image_P;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champs obligatoir")
     */
    private $Description_P;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Quantite_V;


    /**
     * @ORM\ManyToOne(targetEntity=CategorieP::class, inversedBy="produits"  )
     * @ORM\JoinColumn(nullable=false,name="Categorie", referencedColumnName="reference_c")
     */
    private $Categorie;

    /**
     * @ORM\OneToMany(targetEntity=CommandeProduit::class, mappedBy="produit",cascade={"persist"}, cascade={"remove"})
     */
    private $commandeProduits;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couleur;

    public function __construct()
    {
        $this->commandeProduits = new ArrayCollection();
    }

   // /**
     //* @ORM\ManyToMany(targetEntity=Commande::class, inversedBy="produits")
     //* @ORM\JoinTable(name="commandes_produits",
     //*     joinColumns={@ORM\JoinColumn(name="produit_ref", referencedColumnName="reference_p")},
     //*     inverseJoinColumns={@ORM\JoinColumn(name="id_commande",referencedColumnName="id")}
     //*    )
     //*/
    //private $commandes;

   /* public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }*/




    public function getReferenceP(): ?string
    {
        return $this->Reference_P;
    }

    public function setReferenceP(string $Reference_P): self
    {
        $this->Reference_P = $Reference_P;

        return $this;
    }

    public function getNomP(): ?string
    {
        return $this->Nom_P;
    }

    public function setNomP(string $Nom_P): self
    {
        $this->Nom_P = $Nom_P;

        return $this;
    }

    public function getTypeP(): ?string
    {
        return $this->Type_P;
    }

    public function setTypeP(string $Type_P): self
    {
        $this->Type_P = $Type_P;

        return $this;
    }

    public function getMarqueP(): ?string
    {
        return $this->Marque_P;
    }

    public function setMarqueP(string $Marque_P): self
    {
        $this->Marque_P = $Marque_P;

        return $this;
    }

    public function getPrixP(): ?float
    {
        return $this->Prix_P;
    }

    public function setPrixP(float $Prix_P): self
    {
        $this->Prix_P = $Prix_P;

        return $this;
    }

    public function getQuantiteP(): ?int
    {
        return $this->Quantite_P;
    }

    public function setQuantiteP(?int $Quantite_P): self
    {
        $this->Quantite_P = $Quantite_P;

        return $this;
    }

    public function getImageP()
    {
        return $this->Image_P;
    }

    public function setImageP( $Image_P)
    {
        $this->Image_P = $Image_P;

        return $this;
    }

    public function getDescriptionP(): ?string
    {
        return $this->Description_P;
    }

    public function setDescriptionP(string $Description_P): self
    {
        $this->Description_P = $Description_P;

        return $this;
    }

    public function getCategorieP(): ?CategorieP
    {
        return $this->CategorieP;
    }

    public function setCategorieP(?CategorieP $CategorieP): self
    {
        $this->CategorieP = $CategorieP;

        return $this;
    }

    public function getCategorie(): ?CategorieP
    {
        return $this->Categorie;
    }

    public function setCategorie(?CategorieP $Categorie): self
    {
        $this->Categorie = $Categorie;

        return $this;
    }


    public function __toString()
    {
        return (string)$this->getNomP();

    }

    public function getQuantiteV(): ?int
    {
        return $this->Quantite_V;
    }

    public function setQuantiteV(?int $Quantite_V): self
    {
        $this->Quantite_V+= $Quantite_V;

        return $this;
    }

 //   /**
   //  * @return Collection|Commande[]
     //*/
    /*public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
          //  $commande->addProduit($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        $this->commandes->removeElement($commande);

        return $this;
    }*/
    public function nvquantite(?int $nv): self{
        $this->Quantite_P-=$nv;
        return $this;

    }
    public function vente(){
       $vente=$this->getQuantiteV();
       $stock=$this->getQuantiteP();
       $pourcentage=($vente*100)/$stock;
       return $pourcentage;

    }

    /**
     * @return Collection|CommandeProduit[]
     */
    public function getCommandeProduits(): Collection
    {
        return $this->commandeProduits;
    }

    public function addCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if (!$this->commandeProduits->contains($commandeProduit)) {
            $this->commandeProduits[] = $commandeProduit;
            $commandeProduit->setProduit($this);
        }

        return $this;
    }

    public function removeCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if ($this->commandeProduits->removeElement($commandeProduit)) {
            // set the owning side to null (unless already changed)
            if ($commandeProduit->getProduit() === $this) {
                $commandeProduit->setProduit(null);
            }
        }

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }
    }
