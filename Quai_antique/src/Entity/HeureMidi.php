<?php

namespace App\Entity;

use App\Repository\HeureMidiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HeureMidiRepository::class)]
class HeureMidi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $heure= null;

    #[ORM\ManyToOne(targetEntity: InfoTable::class, inversedBy: 'heureMidis')]
    #[ORM\JoinColumn(nullable: false , onDelete:"CASCADE")]
    private ?InfoTable $infoTable = null;

    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'heureMidis')]
    #[ORM\JoinColumn(nullable: false )]
    private $reservation= null;

    public function __construct()
    {
        $this->reservation = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservation(): Collection
    {
        return $this->reservation;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservation->contains($reservation)) {
            $this->reservation->add($reservation);
            $reservation->setHeureMidis($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservation->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getHeureMidis() === $this) {
                $reservation->setHeureMidis(null);
            }
        }

        return $this;
    }
}
