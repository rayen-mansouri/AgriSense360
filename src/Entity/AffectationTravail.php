<?php

namespace App\Entity;

use App\Repository\AffectationTravailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AffectationTravailRepository::class)]
#[ORM\Table(name: 'affectation_travail')]
class AffectationTravail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_affectation')]
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

    /** @var Collection<int, EvaluationPerformance> */
    #[ORM\OneToMany(mappedBy: 'affectationTravail', targetEntity: EvaluationPerformance::class)]
    private Collection $evaluations;

    public function __construct()
    {
        $this->evaluations = new ArrayCollection();
    }

    public function getIdAffectation(): ?int
    {
        return $this->id_affectation;
    }

    public function getId_affectation(): ?int
    {
        return $this->getIdAffectation();
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

    /** @return Collection<int, EvaluationPerformance> */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }
}
