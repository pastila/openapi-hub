<?php

namespace App\Entity;

use App\Repository\OpenApiDocRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=OpenApiDocRepository::class)
 * @Vich\Uploadable()
 */
class OpenApiDoc
{
  use TimestampableEntity;
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @var string
   * @ORM\Column(type="string", length=255)
   */
  private $title;

  /**
   * @var string
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $description;

  /**
   * @var string
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $image;

  /**
   * @var File
   * @Vich\UploadableField(mapping="api", fileNameProperty="image")
   */
  private $imageFile;

  /**
   * @var string
   * @ORM\Column(type="text", nullable=true)
   */
  private $body;

  public function getId (): ?int
  {
    return $this->id;
  }

  public function getTitle (): ?string
  {
    return $this->title;
  }

  public function setTitle (string $title): self
  {
    $this->title = $title;

    return $this;
  }

  public function getBody (): ?string
  {
    return $this->body;
  }

  public function setBody (?string $body): self
  {
    $this->body = $body;

    return $this;
  }

  /**
   * @return string
   */
  public function getDescription ()
  {
    return $this->description;
  }

  /**
   * @param string $description
   * @return $this
   */
  public function setDescription ($description)
  {
    $this->description = $description;
    return $this;
  }

  /**
   * @return string
   */
  public function getImage ()
  {
    return $this->image;
  }

  /**
   * @param string $image
   * @return $this
   */
  public function setImage ($image)
  {
    $this->image = $image;
    return $this;
  }

  /**
   * @return File
   */
  public function getImageFile ()
  {
    return $this->imageFile;
  }

  /**
   * @param File $imageFile
   * @return $this
   */
  public function setImageFile ($imageFile)
  {
    $this->imageFile = $imageFile;
    return $this;
  }

  public function __toString ()
  {
    return $this->getTitle() ?? 'Новое АПИ';
  }
}
