<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'evaluation_performance')]
class EvaluationPerformance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_evaluation = null;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private ?int $note = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $qualite = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_evaluation = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $id_affectation = null;

    public function getIdEvaluation(): ?int
    {
        return $this->id_evaluation;
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

    public function getIdAffectation(): ?int
    {
        return $this->id_affectation;
    }

    public function setIdAffectation(?int $id_affectation): static
    {
        $this->id_affectation = $id_affectation;

        return $this;
    }

}
