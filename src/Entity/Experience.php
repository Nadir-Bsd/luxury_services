<?php

namespace App\Entity;

use App\Repository\ExperienceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExperienceRepository::class)]
class Experience
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $time = null;

    /**
     * @var Collection<int, Candidate>
     */
    #[ORM\OneToMany(targetEntity: Candidate::class, mappedBy: 'Experience')]
    private Collection $Candidate;

    public function __construct()
    {
        $this->Candidate = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->time;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): static
    {
        $this->time = $time;

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
            $candidate->setExperience($this);
        }

        return $this;
    }

    public function removeCandidate(Candidate $candidate): static
    {
        if ($this->Candidate->removeElement($candidate)) {
            // set the owning side to null (unless already changed)
            if ($candidate->getExperience() === $this) {
                $candidate->setExperience(null);
            }
        }

        return $this;
    }
}
