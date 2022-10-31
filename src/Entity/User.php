<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use YoHang88\LetterAvatar\LetterAvatar;

/**
 *@ORM\Table(name="User")
 *
 *@ORM\Entity(repositoryClass=UserRepository::class)
 *@ORM\InheritanceType("JOINED")
 *@UniqueEntity(fields={"email"}, message="Un utilisateur existe déjà avec cette adresse email.")
 *
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @Assert\Length(min=8, minMessage="entrer un nombre de taille egale a 8")
     * @Assert\Positive(message="ce champs doit etre positive")
     * @Assert\NotBlank(message="obligatoire")
     * @ORM\Column(type="integer")
     */
    private $cin;

    /**
     * @ORM\Column(type="string", length=180)
     *
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;
    /**
     *@Assert\NotBlank(message="obligatoire")
     * @Assert\Regex(pattern="/^[a-z]+$/i", message="ce champs n'accepte pas les chiffres")
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @Assert\NotBlank(message="obligatoire")
     * @Assert\Regex(pattern="/^[a-z]+$/i", message="ce champs n'accepte pas les chiffres")
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     *  @Assert\NotBlank(message="obligatoire")
     *  @Assert\Regex(pattern="/^[a-z0-9]+$/i", message="ce champs accepte un format d'adresse")
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     *
     * @Assert\NotBlank(message="obligatoire")
     * @Assert\Positive(message="ce champs doit etre positive")
     * @Assert\Length(min=8, minMessage="entrer un nombre de taille egale a 8")
     * @ORM\Column(type="integer")
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activation_token;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reset_token;
    /**
     * @ORM\OneToMany(targetEntity=ConsLike::class, mappedBy="user")
     */
    private $likes;

    /**
     * @ORM\Column(type="array")
     */
    private $captcha = [];

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="user")
     */
    private $commandes;
    /**
     * @ORM\OneToMany(targetEntity=Forum::class, mappedBy="user", orphanRemoval=true)
     */
    private $forums;

    /**
     * @ORM\OneToMany(targetEntity=Reply::class, mappedBy="User", orphanRemoval=true)
     */
    private $replies;

    /**
     * @ORM\OneToMany(targetEntity=ReplyLike::class, mappedBy="user", orphanRemoval=true)
     */
    private $replyLikes;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=Signal::class, mappedBy="user", orphanRemoval=true)
     */
    private $signals;



    public function __construct()
    {
        $this->forums = new ArrayCollection();
        $this->replies = new ArrayCollection();
        $this->replyLikes = new ArrayCollection();
        $this->signals = new ArrayCollection();

        $this->likes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        //$roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    public function getCin(): ?int
    {
        return $this->cin;
    }
    public function setId(int $id): self
    {
        $this->id= $id;

        return $this;
    }
    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }



    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getActivationToken(): ?string
    {
        return $this->activation_token;
    }

    public function setActivationToken(?string $activation_token): self
    {
        $this->activation_token = $activation_token;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->reset_token;
    }

    public function setResetToken(?string $reset_token): self
    {
        $this->reset_token = $reset_token;

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
            $like->setUser($this);
        }

        return $this;
    }

    public function removeLike(ConsLike $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getUser() === $this) {
                $like->setUser(null);
            }
        }

        return $this;
    }
    public function __toString()
    {

        return (string)$this->getNom();
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
    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setUser($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getUser() === $this) {
                $commande->setUser(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|Forum[]
     */
    public function getForums(): Collection
    {
        return $this->forums;
    }

    public function addForum(Forum $forum): self
    {
        if (!$this->forums->contains($forum)) {
            $this->forums[] = $forum;
            $forum->setUser($this);
        }

        return $this;
    }

    public function removeForum(Forum $forum): self
    {
        if ($this->forums->removeElement($forum)) {
            // set the owning side to null (unless already changed)
            if ($forum->getUser() === $this) {
                $forum->setUser(null);
            }
        }

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
            $reply->setUser($this);
        }

        return $this;
    }

    public function removeReply(Reply $reply): self
    {
        if ($this->replies->removeElement($reply)) {
            // set the owning side to null (unless already changed)
            if ($reply->getUser() === $this) {
                $reply->setUser(null);
            }
        }

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
            $replyLike->setUser($this);
        }

        return $this;
    }

    public function removeReplyLike(ReplyLike $replyLike): self
    {
        if ($this->replyLikes->removeElement($replyLike)) {
            // set the owning side to null (unless already changed)
            if ($replyLike->getUser() === $this) {
                $replyLike->setUser(null);
            }
        }

        return $this;
    }
    public function makeAvatar(){

        /* $path = 'fonts/'.time() . ".png";
         $image = imagecreate(200, 200);
         $red = rand(0, 255);
         $green = rand(0, 255);
         $blue = rand(0, 255);
         imagecolorallocate($image, $red, $green, $blue);
         $textcolor = imagecolorallocate($image, 255,255,255);

         $userUpper = strtoupper($this->getUsername());
         imagettftext($image, 100, 0, 55, 150, $textcolor, realpath('fonts/ARIAL.ttf'),$userUpper[0]);

         imagepng($image, $path);
         imagedestroy($image);*/
        $avatar = new LetterAvatar($this->getNom());
        $avatar->saveAs('path/to/filename');
        return $avatar;








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
            $signal->setUser($this);
        }

        return $this;
    }

    public function removeSignal(Signal $signal): self
    {
        if ($this->signals->removeElement($signal)) {
            // set the owning side to null (unless already changed)
            if ($signal->getUser() === $this) {
                $signal->setUser(null);
            }
        }

        return $this;
    }




}
