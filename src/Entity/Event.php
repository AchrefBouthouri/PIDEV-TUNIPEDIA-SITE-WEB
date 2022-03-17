<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $Date_Debut;

    /**
     * @ORM\Column(type="date")
     */
    private $Date_Fin;

    /**
     * @ORM\Column(type="text")
     */
    private $Description;

    /**
     * @ORM\Column(type="bigint")
     */
    private $Capacite;

    /**
     * @ORM\Column(type="float")
     */
    private $Montant;

    /**
     * @ORM\ManyToOne(targetEntity=Place::class)
     */
    private $Place;

    /**
     * @ORM\OneToOne(targetEntity=Attachement::class, cascade={"persist", "remove"})
     */
    private $Attachement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->Date_Debut;
    }

    public function setDateDebut(\DateTimeInterface $Date_Debut): self
    {
        $this->Date_Debut = $Date_Debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->Date_Fin;
    }

    public function setDateFin(\DateTimeInterface $Date_Fin): self
    {
        $this->Date_Fin = $Date_Fin;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getCapacite(): ?string
    {
        return $this->Capacite;
    }

    public function setCapacite(string $Capacite): self
    {
        $this->Capacite = $Capacite;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->Montant;
    }

    public function setMontant(float $Montant): self
    {
        $this->Montant = $Montant;

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
