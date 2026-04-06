<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\AffectationTravailRepository;

#[ORM\Entity(repositoryClass: AffectationTravailRepository::class)]
#[ORM\Table(name: 'affectation_travail')]
#[Assert\Expression(
    expression: "this.getDateFin() >= this.getDateDebut()",
    message: "La date de fin doit être supérieure ou égale à la date de début"
)]
class AffectationTravail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id_affectation = null;

    public function getId_affectation(): ?int
    {
        return $this->id_affectation;
    }

    public function setId_affectation(int $id_affectation): self
    {
        $this->id_affectation = $id_affectation;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank(message: 'Le type de travail est obligatoire')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Le type de travail doit contenir au moins 2 caractères',
        maxMessage: 'Le type de travail ne doit pas dépasser 100 caractères'
    )]
    private ?string $type_travail = null;

    public function getType_travail(): ?string
    {
        return $this->type_travail;
    }

    public function setType_travail(string $type_travail): self
    {
        $this->type_travail = $type_travail;
        return $this;
    }

    // Aliases for Symfony form compatibility (camelCase)
    public function getTypeTravail(): ?string
    {
        return $this->type_travail;
    }

    public function setTypeTravail(string $type_travail): self
    {
        $this->type_travail = $type_travail;
        return $this;
    }

    #[ORM\Column(type: 'date', nullable: false)]
    #[Assert\NotNull(message: 'La date de début est obligatoire')]
    private ?\DateTimeInterface $date_debut = null;

    public function getDate_debut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDate_debut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;
        return $this;
    }

    // Aliases for Symfony form compatibility (camelCase)
    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;
        return $this;
    }

    #[ORM\Column(type: 'date', nullable: false)]
    #[Assert\NotNull(message: 'La date de fin est obligatoire')]
    private ?\DateTimeInterface $date_fin = null;

    public function getDate_fin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDate_fin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;
        return $this;
    }

    // Aliases for Symfony form compatibility (camelCase)
    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: true)]
    #[Assert\Length(
        max: 100,
        maxMessage: 'La zone de travail ne doit pas dépasser 100 caractères'
    )]
    #[Assert\NotBlank(message: 'La zone de travail est obligatoire')]
    private ?string $zone_travail = null;

    public function getZone_travail(): ?string
    {
        return $this->zone_travail;
    }

    public function setZone_travail(?string $zone_travail): self
    {
        $this->zone_travail = $zone_travail;
        return $this;
    }

    // Aliases for Symfony form compatibility (camelCase)
    public function getZoneTravail(): ?string
    {
        return $this->zone_travail;
    }

    public function setZoneTravail(?string $zone_travail): self
    {
        $this->zone_travail = $zone_travail;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: true)]
    #[Assert\Choice(
        choices: ['En attente', 'En cours', 'Complété', 'Suspendu', 'Annulé'],
        message: 'Le statut doit être valide'
    )]
    #[Assert\NotBlank(message: 'Le statut est obligatoire')]
    private ?string $statut = null;

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

    #[ORM\OneToMany(targetEntity: EvaluationPerformance::class, mappedBy: 'affectationTravail', orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $evaluations;

    public function __construct()
    {
        $this->evaluations = new ArrayCollection();
    }

    /**
     * @return Collection<int, EvaluationPerformance>
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(EvaluationPerformance $evaluation): self
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations->add($evaluation);
            $evaluation->setAffectationTravail($this);
        }

        return $this;
    }

    public function removeEvaluation(EvaluationPerformance $evaluation): self
    {
        if ($this->evaluations->removeElement($evaluation)) {
            if ($evaluation->getAffectationTravail() === $this) {
                $evaluation->setAffectationTravail(null);
            }
        }

        return $this;
    }

}
