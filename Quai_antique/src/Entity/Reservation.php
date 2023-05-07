<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[NotBlank(message : 'Veuillez entrer votre nom !')]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbreConvive = null;

    #[ORM\Column(type: 'json')]
    private $subgroup = null;

    #[ORM\Column(type: 'json')]
    private  $subgroup2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $allergie = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[NotNull()]
    private ?\DateTimeInterface $date = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNbreConvive(): ?int
    {
        return $this->nbreConvive;
    }

    public function setNbreConvive(?int $nbreConvive): self
    {
        $this->nbreConvive = $nbreConvive;

        return $this;
    }

   
    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function isAllergie(): ?bool
    {
        return $this->allergie;
    }

    public function setAllergie(?bool $allergie): self
    {
        $this->allergie = $allergie;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSubgroup(): array
    {
        return $this->subgroup;
    }

    public function setSubgroup(array $subgroup): self
    {
        $this->subgroup = $subgroup;

        return $this;
    }

    public function getSubgroup2(): array
    {
        return $this->subgroup2;
    }

    public function setSubgroup2(array $subgroup2): self
    {
        $this->subgroup2 = $subgroup2;

        return $this;
    }

  
}
