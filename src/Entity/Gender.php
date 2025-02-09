<?php

namespace App\Entity;

use App\Repository\GenderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenderRepository::class)]
class Gender
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Candidate>
     */
    #[ORM\OneToMany(targetEntity: Candidate::class, mappedBy: 'Gender')]
    private Collection $Candidate;

    public function __construct()
    {
        $this->Candidate = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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

    /**
     * @return Collection<int, Candidate>
     */
    public function getCandidate(): Collection
    {
        return $this->Candidate;
    }

    public function addCandidate(Candidate $candidate): static
    {
        if (!$this->Candidate->contains($candidate)) {
            $this->Candidate->add($candidate);
            $candidate->setGender($this);
        }

        return $this;
    }

    public function removeCandidate(Candidate $candidate): static
    {
        if ($this->Candidate->removeElement($candidate)) {
            // set the owning side to null (unless already changed)
            if ($candidate->getGender() === $this) {
                $candidate->setGender(null);
            }
        }

        return $this;
    }
}
