<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'createdItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Maker $maker = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Season $season = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column]
    private ?float $startingPrice = null;

    #[ORM\Column]
    private ?float $currentPrice = null;

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

    public function getMaker(): ?Maker
    {
        return $this->maker;
    }

    public function setMaker(?Maker $maker): static
    {
        $this->maker = $maker;

        return $this;
    }

    public function getSeason(): ?Season
    {
        return $this->season;
    }

    public function setSeason(?Season $season): static
    {
        $this->season = $season;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getStartingPrice(): ?float
    {
        return $this->startingPrice;
    }

    public function setStartingPrice(float $startingPrice): static
    {
        $this->startingPrice = $startingPrice;

        return $this;
    }

    public function getCurrentPrice(): ?float
    {
        return $this->currentPrice;
    }

    public function setCurrentPrice(float $currentPrice): static
    {
        $this->currentPrice = $currentPrice;

        return $this;
    }
}
