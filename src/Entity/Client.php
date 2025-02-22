<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $societyName = null;

    #[ORM\Column(length: 255)]
    private ?string $activity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $notes = null;

    #[ORM\OneToOne(inversedBy: 'client', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    /**
     * @var Collection<int, SocietyContact>
     */
    #[ORM\OneToMany(targetEntity: SocietyContact::class, mappedBy: 'client', orphanRemoval: true)]
    private Collection $societyContacts;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->societyContacts = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->societyName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSocietyName(): ?string
    {
        return $this->societyName;
    }

    public function setSocietyName(string $societyName): static
    {
        $this->societyName = $societyName;

        return $this;
    }

    public function getActivity(): ?string
    {
        return $this->activity;
    }

    public function setActivity(string $activity): static
    {
        $this->activity = $activity;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return Collection<int, SocietyContact>
     */
    public function getSocietyContacts(): Collection
    {
        return $this->societyContacts;
    }

    public function addSocietyContact(SocietyContact $societyContact): static
    {
        if (!$this->societyContacts->contains($societyContact)) {
            $this->societyContacts->add($societyContact);
            $societyContact->setClient($this);
        }

        return $this;
    }

    public function removeSocietyContact(SocietyContact $societyContact): static
    {
        if ($this->societyContacts->removeElement($societyContact)) {
            // set the owning side to null (unless already changed)
            if ($societyContact->getClient() === $this) {
                $societyContact->setClient(null);
            }
        }

        return $this;
    }
}
