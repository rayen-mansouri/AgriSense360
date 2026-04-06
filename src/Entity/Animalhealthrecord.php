<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'animalhealthrecord')]
class Animalhealthrecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private ?int $animal = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: false)]
    private ?\DateTimeInterface $record_date = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $weight = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $appetite = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $condition_status = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $milk_yield = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $egg_count = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $wool_length = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnimal(): ?int
    {
        return $this->animal;
    }

    public function setAnimal(int $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    public function getRecordDate(): ?\DateTime
    {
        return $this->record_date;
    }

    public function setRecordDate(\DateTime $record_date): static
    {
        $this->record_date = $record_date;

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

    public function getAppetite(): ?string
    {
        return $this->appetite;
    }

    public function setAppetite(?string $appetite): static
    {
        $this->appetite = $appetite;

        return $this;
    }

    public function getConditionStatus(): ?string
    {
        return $this->condition_status;
    }

    public function setConditionStatus(?string $condition_status): static
    {
        $this->condition_status = $condition_status;

        return $this;
    }

    public function getMilkYield(): ?float
    {
        return $this->milk_yield;
    }

    public function setMilkYield(?float $milk_yield): static
    {
        $this->milk_yield = $milk_yield;

        return $this;
    }

    public function getEggCount(): ?int
    {
        return $this->egg_count;
    }

    public function setEggCount(?int $egg_count): static
    {
        $this->egg_count = $egg_count;

        return $this;
    }

    public function getWoolLength(): ?float
    {
        return $this->wool_length;
    }

    public function setWoolLength(?float $wool_length): static
    {
        $this->wool_length = $wool_length;

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

}
