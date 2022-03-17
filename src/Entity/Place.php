<?php

namespace App\Entity;

use App\Repository\PlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlaceRepository::class)
 */
class Place
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
    private $Name;

    /**
     * @ORM\Column(type="text")
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Adress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $City;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $PostalCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Latitude;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Longitude;

    /**
     * @ORM\OneToOne(targetEntity=Category::class, cascade={"persist", "remove"})
     */
    private $Category;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $Notice;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Type;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Views;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class)
     */
    private $CreatedBy;

    /**
     * @ORM\OneToMany(targetEntity=Attachement::class, mappedBy="no")
     */
    private $Attachement;

    public function __construct()
    {
        $this->Attachement = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->Adress;
    }

    public function setAdress(string $Adress): self
    {
        $this->Adress = $Adress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(string $City): self
    {
        $this->City = $City;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->PostalCode;
    }

    public function setPostalCode(string $PostalCode): self
    {
        $this->PostalCode = $PostalCode;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->Latitude;
    }

    public function setLatitude(string $Latitude): self
    {
        $this->Latitude = $Latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->Longitude;
    }

    public function setLongitude(string $Longitude): self
    {
        $this->Longitude = $Longitude;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    public function getNotice(): ?int
    {
        return $this->Notice;
    }

    public function setNotice(?int $Notice): self
    {
        $this->Notice = $Notice;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->Status;
    }

    public function setStatus(bool $Status): self
    {
        $this->Status = $Status;

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

    public function getViews(): ?int
    {
        return $this->Views;
    }

    public function setViews(?int $Views): self
    {
        $this->Views = $Views;

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

    /**
     * @return Collection<int, Attachement>
     */
    public function getAttachement(): Collection
    {
        return $this->Attachement;
    }

    public function addAttachement(Attachement $attachement): self
    {
        if (!$this->Attachement->contains($attachement)) {
            $this->Attachement[] = $attachement;
            $attachement->setPlace($this);
        }

        return $this;
    }

    public function removeAttachement(Attachement $attachement): self
    {
        if ($this->Attachement->removeElement($attachement)) {
            // set the owning side to null (unless already changed)
            if ($attachement->getPlace() === $this) {
                $attachement->setPlace(null);
            }
        }

        return $this;
    }
}
