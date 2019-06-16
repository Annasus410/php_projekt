<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Photo.
 *
 * @ORM\Entity(repositoryClass="App\Repository\PhotoRepository")
 * @ORM\Table(
 *     name="photos",
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(
 *              name="UQ_photos_1",
 *              columns={"file"},
 *          ),
 *     },
 * )
 *
 * @UniqueEntity(
 *     fields={"file"}
 * )
 */
class Photo
{
    /**
     * Primary key.
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     *
     * Announcements associated with this picture.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Announcement", inversedBy="photo")
     * @ORM\JoinColumn(nullable=false)
     */
    private $announcement;
/**
* File.
*
* @ORM\Column(
*     type="string",
*     length=191,
*     nullable=false,
*     unique=true,
* )
*
* @Assert\NotBlank
* @Assert\Image(
*     maxSize = "1024k",
*     mimeTypes={"image/png", "image/jpeg", "image/pjpeg", "image/jpeg", "image/pjpeg"},
* )
*/
private $file;

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getAnnouncement(): ?Announcement
    {
        return $this->announcement;
    }

    /**
     * @param Announcement|null $announcement
     * @return Photo
     */
    public function setAnnouncement(?Announcement $announcement): self
    {
        $this->announcement = $announcement;

        return $this;
    }
    /**
     * Getter for File.
     *
     * @return mixed|null File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Setter for File name.
     *
     * @param string $file File
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }
}
