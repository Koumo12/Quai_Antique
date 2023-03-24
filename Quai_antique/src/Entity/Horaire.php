<?php

namespace App\Entity;

use App\Repository\HoraireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HoraireRepository::class)]
class Horaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $MStartTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $MEndTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $SStartTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $SEndTime = null;

    #[ORM\Column]
    private ?bool $isOpen = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getMStartTime(): ?\DateTimeInterface
    {
        return $this->MStartTime;
    }

    public function setMStartTime(?\DateTimeInterface $MStartTime): self
    {
        $this->MStartTime = $MStartTime;

        return $this;
    }

    public function getMEndTime(): ?\DateTimeInterface
    {
        return $this->MEndTime;
    }

    public function setMEndTime(?\DateTimeInterface $MEndTime): self
    {
        $this->MEndTime = $MEndTime;

        return $this;
    }



    public function isIsOpen(): ?bool
    {
        return $this->isOpen;
    }

    public function setIsOpen(bool $isOpen): self
    {
        $this->isOpen = $isOpen;

        return $this;
    }

    public function getSStartTime(): ?\DateTimeInterface
    {
        return $this->SStartTime;
    }

    public function setSStartTime(?\DateTimeInterface $SStartTime): self
    {
        $this->SStartTime = $SStartTime;

        return $this;
    }

    public function getSEndTime(): ?\DateTimeInterface
    {
        return $this->SEndTime;
    }

    public function setSEndTime(?\DateTimeInterface $SEndTime): self
    {
        $this->SEndTime = $SEndTime;

        return $this;
    }

    public function __toString()
    {
        return $this->MStartTime;
    }
}
