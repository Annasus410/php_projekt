<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $CommentContent;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreatedAt;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Announcement", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $announcement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentContent(): ?string
    {
        return $this->CommentContent;
    }

    public function setCommentContent(string $CommentContent): self
    {
        $this->CommentContent = $CommentContent;

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


    public function getAnnouncement(): ?Announcement
    {
        return $this->announcement;
    }

    public function setAnnouncement( $announcement): self
    {

//        $this->announcement = $announcement;

        if ($announcement instanceof Announcement) {
            $this->announcement = $announcement;
        }


        return $this;
    }

    public function getUser()

    {
        return $this->User;
    }

    public function setUser($User): self
    {
        $this->User = $User;

        return $this;
    }

}
