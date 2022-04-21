<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReclamationRepository::class)
 */
class Reclamation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $Text;
  /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $Type;
    /**
     * @ORM\ManyToOne(targetEntity=Person::class)
     */
    private $Created_By;

    /**
     * @ORM\ManyToOne(targetEntity=Place::class)
     */
    private $Place;
   
   
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $help;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $qui;
     /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $seul;
     /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Ce champ est obligatoire")
    *@Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "Le contact doit comporter au moins de {{ limit }} chiffres",
     *      maxMessage = "Le contact doit comporter au moins de {{ limit }} chiffres"
     * )
     */
    private $contact;
    
    /**
     * @ORM\OneToOne(targetEntity=Attachement::class)
     */
    private $Attachement;
    
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->Text;
    }

    public function setText(string $Text): self
    {
        $this->Text = $Text;

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
    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }
    
    public function getHelp(): ?string 
    {
        return $this->help;
    }

    public function setHelp(string $help): self
    {
        $this->help = $help;

        return $this;
    }
    public function getqui(): ?string
    {
        return $this->qui;
    }

    public function setqui(string $qui): self
    {
        $this->qui = $qui;

        return $this;
    }
    public function getseul(): ?string
    {
        return $this->seul;
    }

    public function setseul(string $seul): self
    {
        $this->seul = $seul;

        return $this;
    }
    public function getcontact(): ?int
    {
        return $this->contact;
    }

    public function setcontact(int $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
  
    public function getAttachement(): ?Attachement
    {
        return $this->Attachement;
    }

    public function setAttachement(string $Attachement): self
    {
        $this->Attachement = $Attachement;

        return $this;
    }
    
}
