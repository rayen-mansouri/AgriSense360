<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipmentRepository::class)]
#[ORM\Table(name: 'EQUIPMENTS')]
class Equipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\SequenceGenerator(sequenceName: 'EQUIPMENT_SEQ', allocationSize: 1)]
    #[ORM\Column(name: 'ID', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'NAME', length: 120)]
    private ?string $name = null;

    #[ORM\Column(name: 'TYPE', length: 80)]
    private ?string $type = null;

    #[ORM\Column(name: 'STATUS', length: 30)]
    private ?string $status = null;

    #[ORM\Column(name: 'PURCHASE_DATE', type: 'date', nullable: true)]
    private ?\DateTimeInterface $purchaseDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPurchaseDate(): ?\DateTimeInterface
    {
        return $this->purchaseDate;
    }

    public function setPurchaseDate(?\DateTimeInterface $purchaseDate): self
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }
}
