<?php

namespace App\Entity;

use App\Repository\ConsLikeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConsLikeRepository::class)
 */
class ConsLike
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idl;

    /**
     * @ORM\ManyToOne(targetEntity=Conseil::class, inversedBy="likes")
     * @ORM\JoinColumn(nullable=true,name="reference", referencedColumnName="reference")
     */
    private $conseil;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="likes")
     * @ORM\JoinColumn(nullable=true,name="User", referencedColumnName="id")
     */
    private $user;



    public function getIdl(): ?int
    {
        return $this->idl;
    }

    public function getConseil(): ?Conseil
    {
        return $this->conseil;
    }

    public function setConseil(?Conseil $conseil): self
    {
        $this->conseil = $conseil;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
