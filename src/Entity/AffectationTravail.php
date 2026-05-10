<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'affectation_travail')]
class AffectationTravail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_affectation = null;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    private ?string $type_travail = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: false)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: false)]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $zone_travail = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $statut = null;

    public function getIdAffectation(): ?int
    {
        return $this->id_affectation;
    }

    public function getTypeTravail(): ?string
    {
        return $this->type_travail;
    }

    public function setTypeTravail(string $type_travail): static
    {
        $this->type_travail = $type_travail;

        return $this;
    }

    public function getDateDebut(): ?\DateTime
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTime $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTime
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTime $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getZoneTravail(): ?string
    {
        return $this->zone_travail;
    }

    public function setZoneTravail(?string $zone_travail): static
    {
        $this->zone_travail = $zone_travail;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

}
