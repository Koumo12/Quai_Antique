<?php

namespace App\Entity;

use App\Repository\HeureSoirRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HeureSoirRepository::class)]
class HeureSoir
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $heure = null;

    #[ORM\ManyToOne(targetEntity: InfoTable::class, inversedBy: 'heureSoirs')]
    #[ORM\JoinColumn(nullable: false , onDelete:"CASCADE")]
    private ?InfoTable $infoTable = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(?\DateTimeInterface $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getInfoTable(): ?InfoTable
    {
        return $this->infoTable;
    }

    public function setInfoTable(?InfoTable $infoTable): self
    {
        $this->infoTable = $infoTable;

        return $this;
    }
}
