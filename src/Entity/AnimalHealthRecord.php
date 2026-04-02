<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'animalhealthrecord')]
class AnimalHealthRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Animal::class, inversedBy: 'healthRecords')]
    #[ORM\JoinColumn(name: 'animal', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?Animal $animal = null;

    #[ORM\Column(name: 'recordDate', type: 'date', nullable: true)]
    private ?\DateTimeInterface $recordDate = null;

    #[ORM\Column(name: 'weight', type: 'float', nullable: true)]
    private ?float $weight = null;

    #[ORM\Column(name: 'appetite', type: 'string', length: 50, nullable: true)]
    private ?string $appetite = null;

    #[ORM\Column(name: 'conditionStatus', type: 'string', length: 50, nullable: true)]
    private ?string $conditionStatus = null;

    #[ORM\Column(name: 'milkYield', type: 'float', nullable: true)]
    private ?float $milkYield = null;

    #[ORM\Column(name: 'eggCount', type: 'integer', nullable: true)]
    private ?int $eggCount = null;

    #[ORM\Column(name: 'woolLength', type: 'float', nullable: true)]
    private ?float $woolLength = null;

    #[ORM\Column(name: 'notes', type: 'text', nullable: true)]
    private ?string $notes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): self
    {
        $this->animal = $animal;
        return $this;
    }

    public function getRecordDate(): ?\DateTimeInterface
    {
        return $this->recordDate;
    }

    public function setRecordDate(?\DateTimeInterface $recordDate): self
    {
        $this->recordDate = $recordDate;
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

    public function getAppetite(): ?string
    {
        return $this->appetite;
    }

    public function setAppetite(?string $appetite): self
    {
        $this->appetite = $appetite;
        return $this;
    }

    public function getConditionStatus(): ?string
    {
        return $this->conditionStatus;
    }

    public function setConditionStatus(?string $conditionStatus): self
    {
        $this->conditionStatus = $conditionStatus;
        return $this;
    }

    public function getMilkYield(): ?float
    {
        return $this->milkYield;
    }

    public function setMilkYield(?float $milkYield): self
    {
        $this->milkYield = $milkYield;
        return $this;
    }

    public function getEggCount(): ?int
    {
        return $this->eggCount;
    }

    public function setEggCount(?int $eggCount): self
    {
        $this->eggCount = $eggCount;
        return $this;
    }

    public function getWoolLength(): ?float
    {
        return $this->woolLength;
    }

    public function setWoolLength(?float $woolLength): self
    {
        $this->woolLength = $woolLength;
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }
}
