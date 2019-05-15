<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnnouncementRepository")
 */
class Announcement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Title;

    /**
     * @ORM\Column(type="text", length=5000)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Accepted;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $UserID;

    /**
     * @ORM\Column(type="integer")
     */
    private $CategoryId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getAccepted(): ?bool
    {
        return $this->Accepted;
    }

    public function setAccepted(bool $Accepted): self
    {
        $this->Accepted = $Accepted;

        return $this;
    }

    public function getUserID(): ?int
    {
        return $this->UserID;
    }

    public function setUserID(?int $UserID): self
    {
        $this->UserID = $UserID;

        return $this;
    }

    public function getCategoryId(): ?int
    {
        return $this->CategoryId;
    }

    public function setCategoryId($CategoryId): self
    {
        if($CategoryId instanceof Category) {
            $this->CategoryId = $CategoryId->getId();
        }

        if(is_numeric($CategoryId)){
            $this->CategoryId = $CategoryId;
        }

        return $this;
    }
}
