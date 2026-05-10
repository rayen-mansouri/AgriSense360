<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'maintenance')]
class Maintenance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private ?int $equipment_id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: false)]
    private ?\DateTimeInterface $maintenance_date = null;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    private ?string $maintenance_type = null;

   #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: false)]
private ?string $cost = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipmentId(): ?int
    {
        return $this->equipment_id;
    }

    public function setEquipmentId(int $equipment_id): static
    {
        $this->equipment_id = $equipment_id;

        return $this;
    }

    public function getMaintenanceDate(): ?\DateTime
    {
        return $this->maintenance_date;
    }

    public function setMaintenanceDate(\DateTime $maintenance_date): static
    {
        $this->maintenance_date = $maintenance_date;

        return $this;
    }

    public function getMaintenanceType(): ?string
    {
        return $this->maintenance_type;
    }

    public function setMaintenanceType(string $maintenance_type): static
    {
        $this->maintenance_type = $maintenance_type;

        return $this;
    }

    public function getCost(): ?string
    {
        return $this->cost;
    }

    public function setCost(string $cost): static
    {
        $this->cost = $cost;

        return $this;
    }

}
