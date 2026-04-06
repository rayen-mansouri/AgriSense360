<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'animal')]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $ear_tag = null;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    private ?string $type = null;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    private ?string $gender = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $weight = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $health_status = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birth_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $entry_date = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $origin = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $vaccinated = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $location = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEarTag(): ?int
    {
        return $this->ear_tag;
    }

    public function setEarTag(?int $ear_tag): static
    {
        $this->ear_tag = $ear_tag;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getHealthStatus(): ?string
    {
        return $this->health_status;
    }

    public function setHealthStatus(?string $health_status): static
    {
        $this->health_status = $health_status;

        return $this;
    }

    public function getBirthDate(): ?\DateTime
    {
        return $this->birth_date;
    }

    public function setBirthDate(?\DateTime $birth_date): static
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getEntryDate(): ?\DateTime
    {
        return $this->entry_date;
    }

    public function setEntryDate(?\DateTime $entry_date): static
    {
        $this->entry_date = $entry_date;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(?string $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    public function getVaccinated(): ?int
    {
        return $this->vaccinated;
    }

    public function setVaccinated(?int $vaccinated): static
    {
        $this->vaccinated = $vaccinated;

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

}
