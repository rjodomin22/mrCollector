<?php

namespace App\Entity;

use App\Repository\SeasonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeasonRepository::class)]
class Season
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\Column]
    private ?int $releaseYear = null;

    #[ORM\ManyToOne(inversedBy: 'seasons')]
    private ?Stack $stack = null;

    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'season')]
    private Collection $items;

    #[ORM\Column]
    private ?int $show;


    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getReleaseYear(): ?int
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(int $releaseYear): static
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }

    public function getStack(): ?Stack
    {
        return $this->stack;
    }

    public function setStack(?Stack $stack): static
    {
        $this->stack = $stack;

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setSeason($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getSeason() === $this) {
                $item->setSeason(null);
            }
        }

        return $this;
    }

    public function getShow(): ?int
    {
        return $this->show;
    }

    public function setShow(?int $show): static
    {
        $this->show = $show;

        return $this;
    }

    public function isItemOnSeason(Item $item): bool
    {
        return $this->items->contains($item);
    }
}
