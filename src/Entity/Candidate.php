<?php

namespace App\Entity;

use App\Repository\CandidateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidateRepository::class)]
class Candidate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adress = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nationality = null;

    #[ORM\Column]
    private ?bool $isPassport = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $file_passport = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $file_cv = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $file_pp = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $birth_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $birth_location = null;

    #[ORM\Column]
    private ?bool $isAvailable = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleted_at = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $id_experience = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $id_gender = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $id_user = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $id_job_category = null;

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
        return $this->file_passport;
    }

    public function setFilePassport(?string $file_passport): static
    {
        $this->file_passport = $file_passport;

        return $this;
    }

    public function getFileCv(): ?string
    {
        return $this->file_cv;
    }

    public function setFileCv(?string $file_cv): static
    {
        $this->file_cv = $file_cv;

        return $this;
    }

    public function getFilePp(): ?string
    {
        return $this->file_pp;
    }

    public function setFilePp(?string $file_pp): static
    {
        $this->file_pp = $file_pp;

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
        return $this->birth_date;
    }

    public function setBirthDate(?\DateTimeImmutable $birth_date): static
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getBirthLocation(): ?string
    {
        return $this->birth_location;
    }

    public function setBirthLocation(?string $birth_location): static
    {
        $this->birth_location = $birth_location;

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
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeImmutable $deleted_at): static
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getIdExperience(): ?string
    {
        return $this->id_experience;
    }

    public function setIdExperience(?string $id_experience): static
    {
        $this->id_experience = $id_experience;

        return $this;
    }

    public function getIdGender(): ?string
    {
        return $this->id_gender;
    }

    public function setIdGender(?string $id_gender): static
    {
        $this->id_gender = $id_gender;

        return $this;
    }

    public function getIdUser(): ?string
    {
        return $this->id_user;
    }

    public function setIdUser(string $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdJobCategory(): ?string
    {
        return $this->id_job_category;
    }

    public function setIdJobCategory(?string $id_job_category): static
    {
        $this->id_job_category = $id_job_category;

        return $this;
    }
}
