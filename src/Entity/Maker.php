<?php

namespace App\Entity;

use App\Repository\MakerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MakerRepository::class)]
class Maker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $logo = null;

    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'maker')]
    private Collection $createdItems;

    public function __construct()
    {
        $this->createdItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getCreatedItems(): Collection
    {
        return $this->createdItems;
    }

    public function addCreatedItem(Item $createdItem): static
    {
        if (!$this->createdItems->contains($createdItem)) {
            $this->createdItems->add($createdItem);
            $createdItem->setMaker($this);
        }

        return $this;
    }

    public function removeCreatedItem(Item $createdItem): static
    {
        if ($this->createdItems->removeElement($createdItem)) {
            // set the owning side to null (unless already changed)
            if ($createdItem->getMaker() === $this) {
                $createdItem->setMaker(null);
            }
        }

        return $this;
    }
}
