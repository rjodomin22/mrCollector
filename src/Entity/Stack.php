<?php

namespace App\Entity;

use App\Repository\StackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StackRepository::class)]
class Stack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'createdStacks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $creator = null;

    #[ORM\OneToMany(targetEntity: Season::class, mappedBy: 'stack')]
    private Collection $seasons;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'subscribedStacks')]
    private Collection $subscribers;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $show;

    public function __construct()
    {
        $this->seasons = new ArrayCollection();
        $this->subscribers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): static
    {
        $this->creator = $creator;

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
    /**
     * @return Collection<int, Season>
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }

    public function addSeason(Season $season): static
    {
        if (!$this->seasons->contains($season)) {
            $this->seasons->add($season);
            $season->setStack($this);
        }

        return $this;
    }

    public function removeSeason(Season $season): static
    {
        if ($this->seasons->removeElement($season)) {
            // set the owning side to null (unless already changed)
            if ($season->getStack() === $this) {
                $season->setStack(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getSubscribers(): Collection
    {
        return $this->subscribers;
    }

    public function addSubscriber(User $subscriber): static
    {
        if (!$this->subscribers->contains($subscriber)) {
            $this->subscribers->add($subscriber);
        }

        return $this;
    }

    public function removeSubscriber(User $subscriber): static
    {
        $this->subscribers->removeElement($subscriber);

        return $this;
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

    public function isItemOnAnySeason(?Item $item): bool
    {
        $isOnAnySeason = false;
        foreach($this->seasons as $season) {
            if ($season->isItemOnSeason($item)) {
                $isOnAnySeason = true;
                break;
            }
        }

        return $isOnAnySeason;
    }
}
