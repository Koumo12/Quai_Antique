<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type:"string", length: 255)]
    private  $formule = null;

    #[ORM\Column(type:"string", length: 255)]
    private  $wishDay = null;

    #[ORM\Column(type:"string", length: 255)]
    private  $dishFormule = null;

    #[ORM\Column]
    private ?float $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormule(): ?string
    {
        return $this->formule;
    }

    public function setFormule(string $formule): self
    {
        $this->formule = $formule;

        return $this;
    }

    public function getWishDay(): ?string
    {
        return $this->wishDay;
    }

    public function setWishDay(string $wishDay): self
    {
        $this->wishDay = $wishDay;

        return $this;
    }

    public function getDishFormule(): ?string
    {
        return $this->dishFormule;
    }

    public function setDishFormule(string $dishFormule): self
    {
        $this->dishFormule = $dishFormule;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
