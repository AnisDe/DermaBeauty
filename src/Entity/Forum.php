<?php

namespace App\Entity;

use App\Repository\ForumRepository;
use App\Repository\ReplyLikeRepository;
use App\Repository\ReplyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ForumRepository::class)
 */
class Forum
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
    private $blog;

    /**
     * @ORM\ManyToOne(targetEntity=Sujet::class, inversedBy="yes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sujet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="date")
     */
    private $creation_date;

    /**
     * @ORM\OneToMany(targetEntity=Reply::class, mappedBy="forum", orphanRemoval=true)
     */
    private $replies;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="forums")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;



    public function __construct()
    {
        $this->replies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBlog(): ?string
    {
        return $this->blog;
    }

    public function setBlog(string $blog): self
    {
        $this->blog = $blog;

        return $this;
    }

    public function getSujet(): ?Sujet
    {
        return $this->sujet;
    }

    public function setSujet(?Sujet $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    /**
     * @return Collection|Reply[]
     */
    public function getReplies(): Collection
    {
        return $this->replies;
    }

    public function addReply(Reply $reply): self
    {
        if (!$this->replies->contains($reply)) {
            $this->replies[] = $reply;
            $reply->setForum($this);
        }

        return $this;
    }

    public function removeReply(Reply $reply): self
    {
        if ($this->replies->removeElement($reply)) {
            // set the owning side to null (unless already changed)
            if ($reply->getForum() === $this) {
                $reply->setForum(null);
            }
        }

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

    /**
     * @param ReplyLikeRepository $likeRepository
     * @param ReplyRepository $repository
     * @return Reply[]
     */
    public function sortingLikes(ReplyLikeRepository $likeRepository,ReplyRepository $repository){
        $relies = [];
        foreach ($this->getReplies() as $r){
            $relies[$r->getId()] = $likeRepository->count(['reply'=>$r]);



        }
        arsort($relies);
        $reponses = [];
        foreach ($relies as $id=>$likes){
            $reponses[] = $repository->find($id);



        }
        return $reponses;

    }

    public function getFirstReply(){
        $last_case = $this->getReplies()->count() -1;
        return $this->getReplies()[$last_case];


    }
}
