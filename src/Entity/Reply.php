<?php

namespace App\Entity;

use App\Repository\ReplyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReplyRepository::class)
 */
class Reply
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
    private $content;

    /**
     * @ORM\Column(type="date")
     */
    private $creation_date;

    /**
     * @ORM\ManyToOne(targetEntity=Forum::class, inversedBy="replies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $forum;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="replies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\OneToMany(targetEntity=ReplyLike::class, mappedBy="reply", orphanRemoval=true)
     */
    private $replyLikes;

    /**
     * @ORM\OneToMany(targetEntity=Signal::class, mappedBy="reply", orphanRemoval=true)
     */
    private $signals;



    public function __construct()
    {
        $this->replyLikes = new ArrayCollection();
        $this->signals = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }



    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getForum(): ?Forum
    {
        return $this->forum;
    }

    public function setForum(?Forum $forum): self
    {
        $this->forum = $forum;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return Collection|ReplyLike[]
     */
    public function getReplyLikes(): Collection
    {
        return $this->replyLikes;
    }

    public function addReplyLike(ReplyLike $replyLike): self
    {
        if (!$this->replyLikes->contains($replyLike)) {
            $this->replyLikes[] = $replyLike;
            $replyLike->setReply($this);
        }

        return $this;
    }

    public function removeReplyLike(ReplyLike $replyLike): self
    {
        if ($this->replyLikes->removeElement($replyLike)) {
            // set the owning side to null (unless already changed)
            if ($replyLike->getReply() === $this) {
                $replyLike->setReply(null);
            }
        }

        return $this;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isLikedByUser(User $user){
        foreach ($this->replyLikes as $likes){
            if ($likes->getUser() === $user){
                return true;
            }
        }
        return false;

    }

    /**
     * @return Collection|Signal[]
     */
    public function getSignals(): Collection
    {
        return $this->signals;
    }

    public function addSignal(Signal $signal): self
    {
        if (!$this->signals->contains($signal)) {
            $this->signals[] = $signal;
            $signal->setReply($this);
        }

        return $this;
    }

    public function removeSignal(Signal $signal): self
    {
        if ($this->signals->removeElement($signal)) {
            // set the owning side to null (unless already changed)
            if ($signal->getReply() === $this) {
                $signal->setReply(null);
            }
        }

        return $this;
    }
    /**
     * @param User $user
     * @return bool
     */
    public function isSignaledByUser(User $user){
        foreach ($this->getSignals() as $signal){
            if ($signal->getUser() === $user){
                return true;
            }
        }
        return false;

    }



}
