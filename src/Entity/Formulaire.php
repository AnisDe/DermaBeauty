<?php

namespace App\Entity;

use App\Repository\FormulaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=FormulaireRepository::class)
 */
class Formulaire
{


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     *
     * @ORM\Column(type="integer")
     */
    private $ref;

    /**
     * @Assert\Positive(message="ce champs doit etre positive")
     * @Assert\Length(min=8, minMessage="entrer un nombre de taille egale a 8")
     * @Assert\NotBlank(message="ce champs est obligatoire")
     * @ORM\Column(type="integer")
     *
     */
    private $cin;

    /**
     * @Assert\NotBlank(message="ce champs est obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $quest1;

    /**
     * @Assert\NotBlank(message="ce champs est obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $quest2;

    /**
     * @Assert\NotBlank(message="ce champs est obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $quest3;

    /**
     * @Assert\NotBlank(message="ce champs est obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $quest4;

    /**
     * @Assert\NotBlank(message="ce champs est obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $quest5;

    /**
     * @Assert\NotBlank(message="ce champs est obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $quest6;

    /**
     * @Assert\NotBlank(message="ce champs est obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=FormCateg::class, inversedBy="formulaire" , cascade="remove")
     * @ORM\JoinColumn(nullable=false ,name="FormCateg", referencedColumnName="id_cat")
     */
    private $FormCateg;

    /**
     * @ORM\Column(type="array")
     */
    private $captcha = [];












    public function getRef(): ?int
    {
        return $this->ref;
    }


    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(int $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getQuest1(): ?string
    {
        return $this->quest1;
    }

    public function setQuest1(string $quest1): self
    {
        $this->quest1 = $quest1;

        return $this;
    }

    public function getQuest2(): ?string
    {
        return $this->quest2;
    }

    public function setQuest2(string $quest2): self
    {
        $this->quest2 = $quest2;

        return $this;
    }

    public function getQuest3(): ?string
    {
        return $this->quest3;
    }

    public function setQuest3(string $quest3): self
    {
        $this->quest3 = $quest3;

        return $this;
    }

    public function getQuest4(): ?string
    {
        return $this->quest4;
    }

    public function setQuest4(string $quest4): self
    {
        $this->quest4 = $quest4;

        return $this;
    }

    public function getQuest5(): ?string
    {
        return $this->quest5;
    }

    public function setQuest5(string $quest5): self
    {
        $this->quest5 = $quest5;

        return $this;
    }

    public function getQuest6(): ?string
    {
        return $this->quest6;
    }

    public function setQuest6(string $quest6): self
    {
        $this->quest6 = $quest6;

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

    public function getFormCateg(): ?FormCateg
    {
        return $this->FormCateg;
    }

    public function setFormCateg(?FormCateg $FormCateg): self
    {
        $this->FormCateg = $FormCateg;

        return $this;
    }

    public function getCaptcha(): ?array
    {
        return $this->captcha;
    }

    public function setCaptcha(array $captcha): self
    {
        $this->captcha = $captcha;

        return $this;
    }

  


}
