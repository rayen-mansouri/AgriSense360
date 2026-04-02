<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'animal')]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'earTag', type: 'integer')]
    private ?int $earTag = null;

    #[ORM\Column(name: 'type', type: 'string', length: 50)]
    private ?string $type = null;

    #[ORM\Column(name: 'weight', type: 'float', nullable: true)]
    private ?float $weight = null;

    #[ORM\Column(name: 'healthStatus', type: 'string', length: 50, nullable: true)]
    private ?string $healthStatus = null;

    #[ORM\Column(name: 'birthDate', type: 'date', nullable: true)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(name: 'entryDate', type: 'date', nullable: true)]
    private ?\DateTimeInterface $entryDate = null;

    #[ORM\Column(name: 'origin', type: 'string', length: 50, nullable: true)]
    private ?string $origin = null;

    #[ORM\Column(name: 'vaccinated', type: 'boolean', nullable: true)]
    private ?bool $vaccinated = null;

    #[ORM\Column(name: 'location', type: 'string', length: 100, nullable: true)]
    private ?string $location = null;

    #[ORM\OneToMany(mappedBy: 'animal', targetEntity: AnimalHealthRecord::class)]
    private Collection $healthRecords;

    public function __construct()
    {
        $this->healthRecords = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEarTag(): ?int
    {
        return $this->earTag;
    }

    public function setEarTag(?int $earTag): self
    {
        $this->earTag = $earTag;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;
        return $this;
    }

    public function getHealthStatus(): ?string
    {
        return $this->healthStatus;
    }

    public function setHealthStatus(?string $healthStatus): self
    {
        $this->healthStatus = $healthStatus;
        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getEntryDate(): ?\DateTimeInterface
    {
        return $this->entryDate;
    }

    public function setEntryDate(?\DateTimeInterface $entryDate): self
    {
        $this->entryDate = $entryDate;
        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(?string $origin): self
    {
        $this->origin = $origin;
        return $this;
    }

    public function isVaccinated(): ?bool
    {
        return $this->vaccinated;
    }

    public function setVaccinated(?bool $vaccinated): self
    {
        $this->vaccinated = $vaccinated;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getAge(): ?int
    {
        if (!$this->birthDate instanceof \DateTimeInterface) {
            return null;
        }
        return (int) $this->birthDate->diff(new \DateTimeImmutable('today'))->y;
    }
}
