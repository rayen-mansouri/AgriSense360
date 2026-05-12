<?php

namespace App\Entity;

use App\Repository\EvaluationPerformanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvaluationPerformanceRepository::class)]
#[ORM\Table(name: 'evaluation_performance')]
class EvaluationPerformance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_evaluation')]
    private ?int $id_evaluation = null;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private ?int $note = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $qualite = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_evaluation = null;

    #[ORM\ManyToOne(targetEntity: AffectationTravail::class, inversedBy: 'evaluations')]
    #[ORM\JoinColumn(name: 'id_affectation', referencedColumnName: 'id_affectation', nullable: true)]
    private ?AffectationTravail $affectationTravail = null;

    public function getIdEvaluation(): ?int
    {
        return $this->id_evaluation;
    }

    public function getId_evaluation(): ?int
    {
        return $this->getIdEvaluation();
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getQualite(): ?string
    {
        return $this->qualite;
    }

    public function setQualite(?string $qualite): static
    {
        $this->qualite = $qualite;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getDateEvaluation(): ?\DateTime
    {
        return $this->date_evaluation;
    }

    public function setDateEvaluation(?\DateTime $date_evaluation): static
    {
        $this->date_evaluation = $date_evaluation;

        return $this;
    }

    public function getAffectationTravail(): ?AffectationTravail
    {
        return $this->affectationTravail;
    }

    public function setAffectationTravail(?AffectationTravail $affectationTravail): static
    {
        $this->affectationTravail = $affectationTravail;

        return $this;
    }

    public function getIdAffectation(): ?int
    {
        return $this->affectationTravail?->getIdAffectation();
    }
}
