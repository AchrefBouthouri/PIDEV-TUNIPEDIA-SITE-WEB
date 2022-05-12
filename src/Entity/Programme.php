<?php

namespace App\Entity;

use App\Repository\ProgrammeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProgrammeRepository::class)
 */
class Programme
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="le nom est requis")
     * @Assert\Regex(pattern="/^[a-zA-z]*$/" ,match=true ,message="seuls les alphabets sont autorisés")
     * @Assert\Length(min=3,max=20 , minMessage="le nom doit comporter au moins {{ limit }} caractères",
     *     maxMessage="le nom doit comporter au plus {{ limit }} caractères")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="la description est requis")
     * @Assert\Length(min=10,max=200 , minMessage="Votre description doit comporter au moins {{ limit }} caractères",
     *     maxMessage="Votre description doit comporter au plus {{ limit }} caractères")
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="Programme")
     */
    private $createdby;

  

    /**
     * @ORM\Column(type="float")
     * * @Assert\NotBlank(message="le prix est requis")
     * *  @Assert\Regex(pattern="/^[0-9]*$/" ,match=true ,message="seuls les chiffre sont autorisés")
     */
    private $prix;

    public function __construct()
    {
        $this->places = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCreatedby(): ?person
    {
        return $this->createdby;
    }

    public function setCreatedby(?person $createdby): self
    {
        $this->createdby = $createdby;

        return $this;
    }

   
    

   

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
