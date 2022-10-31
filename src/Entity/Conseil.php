<?php

namespace App\Entity;

use App\Entity\User;
use App\Repository\ConseilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ConseilRepository::class)
 */
class Conseil
{


    /**
     * @ORM\Id
     * @Assert\Positive(message="ce champs doit etre positive")
     * @Assert\NotBlank(message="obligatoire")
     * @ORM\Column(type="integer")
     *
     */
    private $reference;

    /**
     *
     * @Assert\NotBlank(message="le nom est obligatoire")
     * @Assert\Regex(pattern="/^[a-z]+$/i", message="ce champs n'accepte pas les chiffres")
     * @ORM\Column(type="string", length=255)
     */
    private $remarques;

    /**
     *
     * @ORM\Column(type="date")
     */
    private $date_red;

    /**
     * @ORM\Column(type="date")
     */
    private $date_limite;

    /**
     * @Assert\NotBlank(message="le nom est obligatoire")
     * @Assert\Regex(pattern="/^[a-z]+$/i", message="ce champs n'accepte pas les chiffres")
     * @ORM\Column(type="string", length=255)
     */
    private $nom_derma;

    /**
     * @Assert\Email(message="saisir votre email correctement")
     * @Assert\NotBlank(message="le nom est obligatoire")
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=ConsLike::class, mappedBy="conseil")
     */
    private $likes;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }






    public function getReference(): ?int
    {
        return $this->reference;
    }
    public function setReference(int $reference): self
    {
       $this->reference= $reference;
       return $this;
    }


    public function getRemarques(): ?string
    {
        return $this->remarques;
    }

    public function setRemarques(string $remarques): self
    {
        $this->remarques = $remarques;

        return $this;
    }

    public function getDateRed(): ?\DateTimeInterface
    {
        return $this->date_red;
    }

    public function setDateRed(\DateTimeInterface $date_red): self
    {
        $this->date_red = $date_red;

        return $this;
    }

    public function getDateLimite(): ?\DateTimeInterface
    {
        return $this->date_limite;
    }

    public function setDateLimite(\DateTimeInterface $date_limite): self
    {
        $this->date_limite = $date_limite;

        return $this;
    }

    public function getNomDerma(): ?string
    {
        return $this->nom_derma;
    }

    public function setNomDerma(string $nom_derma): self
    {
        $this->nom_derma = $nom_derma;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|ConsLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(ConsLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setConseil($this);
        }

        return $this;
    }

    public function removeLike(ConsLike $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getConseil() === $this) {
                $like->setConseil(null);
            }
        }

        return $this;
    }


    /**
     * @param \App\Entity\User $user
     * @return bool
     */
    public function islikedByUser(User $user) : bool
    {  foreach ($this->likes as $like)
    {  if ($like->getUser()===$user) return true ;
    }
        return false;
    }
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return (string)$this->getNomDerma();
    }
}
