<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See http://symfony.com/doc/current/best_practices/configuration.html#constants-vs-configuration-options
     *
     * @constant int NUMBER_OF_ITEMS
     */
    const NUMBER_OF_ITEMS = 7;


    /**
     * Role user.
     *
     * @var string
     */
    const ROLE_USER = 'ROLE_USER';

    /**
     * Role admin.
     *
     * @var string
     */
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Password;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Announcement", mappedBy="User", orphanRemoval=true)
     */
    private $announcements;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Opinion", mappedBy="Author", orphanRemoval=true)
     */
    private $opinions;


    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserData", inversedBy="user", cascade={"persist", "remove"})
     */
    private $UserData;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Gedmo\Timestampable(on="create")
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Comment", mappedBy="User", cascade={"persist", "remove"})
     */
    private $comment;


    public function __construct()
    {
        $this->announcements = new ArrayCollection();
        $this->opinions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->Login;
    }

    public function setLogin(string $Login): self
    {
        $this->Login = $Login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): self
    {
        $this->Password = $Password;

        return $this;
    }


    /**
     * @return Collection|Announcement[]
     */
    public function getAnnouncements(): Collection
    {
        return $this->announcements;
    }

    public function addAnnouncement(Announcement $announcement): self
    {
        if (!$this->announcements->contains($announcement)) {
            $this->announcements[] = $announcement;
            $announcement->setUser($this);
        }

        return $this;
    }

    public function removeAnnouncement(Announcement $announcement): self
    {
        if ($this->announcements->contains($announcement)) {
            $this->announcements->removeElement($announcement);
            // set the owning side to null (unless already changed)
            if ($announcement->getUser() === $this) {
                $announcement->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Opinion[]
     */
    public function getOpinions(): Collection
    {
        return $this->opinions;
    }

    public function addOpinion(Opinion $opinion): self
    {
        if (!$this->opinions->contains($opinion)) {
            $this->opinions[] = $opinion;
            $opinion->setAuthor($this);
        }

        return $this;
    }

    public function removeOpinion(Opinion $opinion): self
    {
        if ($this->opinions->contains($opinion)) {
            $this->opinions->removeElement($opinion);
            // set the owning side to null (unless already changed)
            if ($opinion->getAuthor() === $this) {
                $opinion->setAuthor(null);
            }
        }

        return $this;
    }


    public function getUserData(): ?UserData
    {
        return $this->UserData;
    }

    public function setUserData(?UserData $UserData): self
    {
        $this->UserData = $UserData;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    /**
* @see UserInterface
*/
    public function getSalt()
    {
        // not needed when using bcrypt or argon
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    /**
     * {@inheritdoc}
     *
     * @see UserInterface
     *
     * @return string User name
     */
    public function getUsername(): string
    {
        return (string) $this->Login;
    }

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(Comment $comment): self
    {
        $this->comment = $comment;

        // set the owning side of the relation if necessary
        if ($this !== $comment->getUser()) {
            $comment->setUser($this);
        }

        return $this;
    }
}