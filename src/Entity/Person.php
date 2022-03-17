<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $FullName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Password;

    /**
     * @ORM\OneToOne(targetEntity=Attachement::class, cascade={"persist", "remove"})
     */
    private $Avatar;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Nationalite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Role;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreatedAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $HasPlaces;

    /**
     * @ORM\Column(type="boolean")
     */
    private $IsPartner;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $Balance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->FullName;
    }

    public function setFullName(string $FullName): self
    {
        $this->FullName = $FullName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

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

    public function getAvatar(): ?Attachement
    {
        return $this->Avatar;
    }

    public function setAvatar(?Attachement $Avatar): self
    {
        $this->Avatar = $Avatar;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->Gender;
    }

    public function setGender(?string $Gender): self
    {
        $this->Gender = $Gender;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->Nationalite;
    }

    public function setNationalite(?string $Nationalite): self
    {
        $this->Nationalite = $Nationalite;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->Role;
    }

    public function setRole(string $Role): self
    {
        $this->Role = $Role;

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

    public function getHasPlaces(): ?bool
    {
        return $this->HasPlaces;
    }

    public function setHasPlaces(?bool $HasPlaces): self
    {
        $this->HasPlaces = $HasPlaces;

        return $this;
    }

    public function getIsPartner(): ?bool
    {
        return $this->IsPartner;
    }

    public function setIsPartner(bool $IsPartner): self
    {
        $this->IsPartner = $IsPartner;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->Balance;
    }

    public function setBalance(?float $Balance): self
    {
        $this->Balance = $Balance;

        return $this;
    }
}
