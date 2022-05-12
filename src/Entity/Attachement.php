<?php

namespace App\Entity;

use App\Repository\AttachementRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation\uploadable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity(repositoryClass=AttachementRepository::class)
 */
class Attachement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("Places")
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     */
    private $Path;

   private $file;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->Path;
    }

    public function setPath(string $Path): self
    {
        $this->Path = $Path;

        return $this;
    }
    public function getFile()
    {
        return $this->file;
    }
    public function setFile(UploadedFile $file): void
    {
        $this->file = $file;
    }
}
