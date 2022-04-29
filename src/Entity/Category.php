<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Symfony\Component\Validator\Constraints as Assert ;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5,max=30,minMessage="il faut au moin 5 carac",maxMessage="il faut au max 30 carac")
     * @Assert\NotBlank
     * @Groups("Category")
     */
    private $Name;

    /**
     * @ORM\OneToOne(targetEntity=Attachement::class, cascade={"persist", "remove"})
     */
    private $Attachement;

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

    public function getAttachement(): ?Attachement
    {
        return $this->Attachement;
    }

    public function setAttachement(?Attachement $Attachement): self
    {
        $this->Attachement = $Attachement;

        return $this;
    }
}
