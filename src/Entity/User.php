<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    private ?string $email = null;

    #[ORM\OneToMany(targetEntity: Stack::class, mappedBy: 'creator')]
    private Collection $createdStacks;

    #[ORM\ManyToMany(targetEntity: Stack::class, mappedBy: 'subscribers')]
    private Collection $subscribedStacks;

    #[ORM\OneToMany(targetEntity: UserItem::class, mappedBy: 'relatedUser')]
    private Collection $myItems;

    public function __construct()
    {
        $this->createdStacks = new ArrayCollection();
        $this->subscribedStacks = new ArrayCollection();
        $this->myItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Stack>
     */
    public function getCreatedStacks(): Collection
    {
        return $this->createdStacks;
    }

    public function addCreatedStack(Stack $createdStack): static
    {
        if (!$this->createdStacks->contains($createdStack)) {
            $this->createdStacks->add($createdStack);
            $createdStack->setCreator($this);
        }

        return $this;
    }

    public function removeCreatedStack(Stack $createdStack): static
    {
        if ($this->createdStacks->removeElement($createdStack)) {
            // set the owning side to null (unless already changed)
            if ($createdStack->getCreator() === $this) {
                $createdStack->setCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Stack>
     */
    public function getSubscribedStacks(): Collection
    {
        return $this->subscribedStacks;
    }

    public function addSubscribedStack(Stack $subscribedStack): static
    {
        if (!$this->subscribedStacks->contains($subscribedStack)) {
            $this->subscribedStacks->add($subscribedStack);
            $subscribedStack->addSubscriber($this);
        }

        return $this;
    }

    public function removeSubscribedStack(Stack $subscribedStack): static
    {
        if ($this->subscribedStacks->removeElement($subscribedStack)) {
            $subscribedStack->removeSubscriber($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, UserItem>
     */
    public function getMyItems(): Collection
    {
        return $this->myItems;
    }

    public function addMyItem(UserItem $myItem): static
    {
        if (!$this->myItems->contains($myItem)) {
            $this->myItems->add($myItem);
            $myItem->setRelatedUser($this);
        }

        return $this;
    }

    public function removeMyItem(UserItem $myItem): static
    {
        if ($this->myItems->removeElement($myItem)) {
            // set the owning side to null (unless already changed)
            if ($myItem->getRelatedUser() === $this) {
                $myItem->setRelatedUser(null);
            }
        }

        return $this;
    }
}
