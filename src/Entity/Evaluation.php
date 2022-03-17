<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvaluationRepository::class)
 */
class Evaluation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $Notice;

    /**
     * @ORM\Column(type="text")
     */
    private $Comment;

    /**
     * @ORM\Column(type="date")
     */
    private $CreatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class)
     */
    private $CreatedBy;

    /**
     * @ORM\ManyToOne(targetEntity=Place::class)
     */
    private $Place;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getComment(): ?string
    {
        return $this->Comment;
    }

    public function setComment(string $Comment): self
    {
        $this->Comment = $Comment;

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
}
