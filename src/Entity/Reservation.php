<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("Reservation:read")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="la date est requis")
     * @Groups("Reservation:read")
     */
    private $Date;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="le nom est requis")
     * @Assert\Regex(pattern="/^[a-zA-z]*$/" ,match=true ,message="seuls les alphabets sont autorisés")
     * @Assert\Length(min=3,max=20 , minMessage="Votre nom doit comporter au moins {{ limit }} caractères",
     *     maxMessage="Votre nom doit comporter au plus {{ limit }} caractères")
     *  @Groups("Reservation:read")
     */
    private $Nom;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="le prenom est requis")
     * @Assert\Regex(pattern="/^[a-zA-z]*$/" ,match=true ,message="seuls les alphabets sont autorisés")
     * @Assert\Length(min=3,max=20 , minMessage="Votre prenom doit comporter au moins {{ limit }} caractères",
     *     maxMessage="Votre prenom doit comporter au plus {{ limit }} caractères")
     *  @Groups("Reservation:read")
     */
    
    private $Prenom;
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="le nombre de place est requis")
     * @Groups("Reservation:read")
     */
    private $Nbrplace;
    /**
     * @ORM\Column(type="boolean")
     * @Assert\GreaterThan(0)
     * 
     */
    private $Validation;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class)
     */
    private $CreatedBy;

    /**
     * @ORM\ManyToOne(targetEntity=Place::class)
     */
    private $Place;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class)
     */
    private $Event;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getValidation(): ?bool
    {
        return $this->Validation;
    }

    public function setValidation(bool $Validation): self
    {
        $this->Validation = $Validation;

        return $this;
    }

    public function getCreatedBy(): ?Person
    {
        return $this->CreatedBy;
    }

    public function setCreatedBy(?Person $CreatedBy): self
    {
        $this->CreatedBy = $CreatedBy;

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->Place;
    }

    public function setPlace(?Place $Place): self
    {
        $this->Place = $Place;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->Event;
    }
    public function getNom(): ?string
    {
        return $this->Nom;
    }
    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function getNbrplace(): ?int
    {
        return $this->Nbrplace;
    }
    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }
    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }
    public function setNbrplace(int $Nbrplace): self
    {
        $this->Nbrplace = $Nbrplace;

        return $this;
    }

    public function setEvent(?Event $Event): self
    {
        $this->Event = $Event;

        return $this;
    }
}
