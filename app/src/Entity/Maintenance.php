<?php

namespace App\Entity;

use App\Repository\MaintenanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaintenanceRepository::class)]
#[ORM\Table(name: 'MAINTENANCE')]
class Maintenance
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\SequenceGenerator(sequenceName: 'MAINTENANCE_SEQ', allocationSize: 1)]
    #[ORM\Column(name: 'ID', type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Equipment::class)]
    #[ORM\JoinColumn(name: 'EQUIPMENT_ID', referencedColumnName: 'ID', nullable: false)]
    private ?Equipment $equipment = null;

    #[ORM\Column(name: 'MAINTENANCE_DATE', type: 'date')]
    private ?\DateTimeInterface $maintenanceDate = null;

    #[ORM\Column(name: 'MAINTENANCE_TYPE', length: 80)]
    private ?string $maintenanceType = null;

    #[ORM\Column(name: 'COST', type: 'decimal', precision: 10, scale: 2)]
    private ?string $cost = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(?Equipment $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }

    public function getMaintenanceDate(): ?\DateTimeInterface
    {
        return $this->maintenanceDate;
    }

    public function setMaintenanceDate(?\DateTimeInterface $maintenanceDate): self
    {
        $this->maintenanceDate = $maintenanceDate;

        return $this;
    }

    public function getMaintenanceType(): ?string
    {
        return $this->maintenanceType;
    }

    public function setMaintenanceType(?string $maintenanceType): self
    {
        $this->maintenanceType = $maintenanceType;

        return $this;
    }

    public function getCost(): ?string
    {
        return $this->cost;
    }

    public function setCost(?string $cost): self
    {
        $this->cost = $cost;

        return $this;
    }
}
