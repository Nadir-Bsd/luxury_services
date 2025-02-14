<?php

namespace App\Entity;

use App\Attribute\ProfileField;
use App\Repository\CandidateRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidateRepository::class)]
class Candidate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ProfileField]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstname = null;

    #[ProfileField]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ProfileField]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adress = null;

    #[ProfileField]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[ProfileField]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nationality = null;

    #[ORM\Column]
    private ?bool $isPassport = false;

    #[ProfileField]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $filePassport = null;

    #[ProfileField]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fileCv = null;

    #[ProfileField]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $filePp = null;

    #[ProfileField]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ProfileField]
    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $birthDate = null;

    #[ProfileField]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $birthLocation = null;

    #[ORM\Column]
    private ?bool $isAvailable = false;

    #[ProfileField]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\OneToOne(inversedBy: 'Candidate', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ProfileField]
    #[ORM\ManyToOne(inversedBy: 'Candidate')]
    private ?Gender $Gender = null;

    #[ProfileField]
    #[ORM\ManyToOne(inversedBy: 'Candidate')]
    private ?Experience $Experience = null;

    #[ProfileField]
    #[ORM\ManyToOne(inversedBy: 'Candidate')]
    private ?Category $Category = null;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private int $CompletionPercentage = 0;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(?string $nationality): static
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function isPassport(): ?bool
    {
        return $this->isPassport;
    }

    public function setIsPassport(?bool $isPassport): static
    {
        $this->isPassport = $isPassport;

        return $this;
    }

    public function getFilePassport(): ?string
    {
        return $this->filePassport;
    }

    public function setFilePassport(?string $filePassport): static
    {
        $this->filePassport = $filePassport;

        return $this;
    }

    public function getFileCv(): ?string
    {
        return $this->fileCv;
    }

    public function setFileCv(?string $fileCv): static
    {
        $this->fileCv = $fileCv;

        return $this;
    }

    public function getFilePp(): ?string
    {
        return $this->filePp;
    }

    public function setFilePp(?string $filePp): static
    {
        $this->filePp = $filePp;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeImmutable $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getBirthLocation(): ?string
    {
        return $this->birthLocation;
    }

    public function setBirthLocation(?string $birthLocation): static
    {
        $this->birthLocation = $birthLocation;

        return $this;
    }

    public function isAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): static
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(): static
    {
        $this->deletedAt = new DateTimeImmutable();

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(User $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->Gender;
    }

    public function setGender(?Gender $Gender): static
    {
        $this->Gender = $Gender;

        return $this;
    }

    public function getExperience(): ?Experience
    {
        return $this->Experience;
    }

    public function setExperience(?Experience $Experience): static
    {
        $this->Experience = $Experience;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): static
    {
        $this->Category = $Category;

        return $this;
    }

    public function getCompletionPercentage(): ?int
    {
        return $this->CompletionPercentage;
    }

    public function setCompletionPercentage(int $CompletionPercentage): static
    {
        $this->CompletionPercentage = $CompletionPercentage;

        return $this;
    }
}
