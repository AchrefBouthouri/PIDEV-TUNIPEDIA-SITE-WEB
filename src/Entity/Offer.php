<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=OfferRepository::class)
 */
class Offer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="le date debut est requis")
     */
    private $Date_Debut;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="le date fin est requis")
     */
    private $Date_Fin;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="le montantest requis")
     *  @Assert\Regex(pattern="/^[0-9]*$/" ,match=true ,message="seuls les chiffre sont autorisés")
     */
    private $Montant;

    /**
     * @ORM\OneToOne(targetEntity=Event::class, cascade={"persist", "remove"})
     */
    private $Event;

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

    public function getMontant(): ?float
    {
        return $this->Montant;
    }

    public function setMontant(float $Montant): self
    {
        $this->Montant = $Montant;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->Event;

    }
    

    public function setEvent(?Event $Event): self
    {
        $this->Event = $Event;

        return $this;
    }
}
