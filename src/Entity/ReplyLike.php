<?php

namespace App\Entity;

use App\Repository\ReplyLikeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReplyLikeRepository::class)
 */
class ReplyLike
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="replyLikes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Reply::class, inversedBy="replyLikes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reply;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getReply(): ?Reply
    {
        return $this->reply;
    }

    public function setReply(?Reply $reply): self
    {
        $this->reply = $reply;

        return $this;
    }
}
