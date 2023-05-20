<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[NotBlank()]
    private ?string $titel = null;

    #[ORM\OneToMany(targetEntity: "App\Entity\Carte", mappedBy: "category")]
    #[NotBlank()]
    private  $plat = null;

    public function __construct()
    {
        $this->plat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitel(): ?string
    {
        return $this->titel;
    }

    public function setTitel(string $titel): self
    {
        $this->titel = $titel;

        return $this;
    }

    /**
     * @return Collection<int, Carte>
     */
    public function getPlat(): Collection
    {
        return $this->plat;
    }

    public function addPlat(Carte $plat): self
    {
        if (!$this->plat->contains($plat)) {
            $this->plat->add($plat);
            $plat->setCategory($this);
        }

        return $this;
    }

    public function removePlat(Carte $plat): self
    {
        if ($this->plat->removeElement($plat)) {
            // set the owning side to null (unless already changed)
            if ($plat->getCategory() === $this) {
                $plat->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->titel;
    }
}
