<?php

namespace App\Entity;

use App\Repository\ComponentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComponentsRepository::class)]
class Components
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Receipt>
     */
    #[ORM\OneToMany(targetEntity: Receipt::class, mappedBy: 'components')]
    private Collection $prescription;

    /**
     * @var Collection<int, Ingredient>
     */
    #[ORM\OneToMany(targetEntity: Ingredient::class, mappedBy: 'components')]
    private Collection $ingredient;

    #[ORM\Column(length: 255)]
    private ?string $amount = null;

    public function __construct()
    {
        $this->prescription = new ArrayCollection();
        $this->ingredient = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Receipt>
     */
    public function getPrescription(): Collection
    {
        return $this->prescription;
    }

    public function addPrescription(Receipt $prescription): static
    {
        if (!$this->prescription->contains($prescription)) {
            $this->prescription->add($prescription);
            $prescription->setComponents($this);
        }

        return $this;
    }

    public function removePrescription(Receipt $prescription): static
    {
        if ($this->prescription->removeElement($prescription)) {
            // set the owning side to null (unless already changed)
            if ($prescription->getComponents() === $this) {
                $prescription->setComponents(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredient(): Collection
    {
        return $this->ingredient;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredient->contains($ingredient)) {
            $this->ingredient->add($ingredient);
            $ingredient->setComponents($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        if ($this->ingredient->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getComponents() === $this) {
                $ingredient->setComponents(null);
            }
        }

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }
}
