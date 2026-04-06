<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\EvaluationPerformanceRepository;

#[ORM\Entity(repositoryClass: EvaluationPerformanceRepository::class)]
#[ORM\Table(name: 'evaluation_performance')]
class EvaluationPerformance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id_evaluation = null;

    public function getId_evaluation(): ?int
    {
        return $this->id_evaluation;
    }

    public function setId_evaluation(int $id_evaluation): self
    {
        $this->id_evaluation = $id_evaluation;
        return $this;
    }

    #[ORM\Column(type: 'integer', nullable: false)]
    private ?int $id_affectation = null;

    #[ORM\ManyToOne(targetEntity: AffectationTravail::class, inversedBy: 'evaluations')]
    #[ORM\JoinColumn(name: 'id_affectation', referencedColumnName: 'id_affectation', nullable: false)]
    #[Assert\NotNull(message: 'L\'affectation est obligatoire')]
    private ?AffectationTravail $affectationTravail = null;

    public function getId_affectation(): ?int
    {
        return $this->id_affectation;
    }

    public function setId_affectation(int $id_affectation): self
    {
        $this->id_affectation = $id_affectation;
        return $this;
    }

    public function getAffectationTravail(): ?AffectationTravail
    {
        return $this->affectationTravail;
    }

    public function setAffectationTravail(?AffectationTravail $affectationTravail): self
    {
        $this->affectationTravail = $affectationTravail;
        return $this;
    }

    #[ORM\Column(type: 'integer', nullable: false)]
    #[Assert\NotNull(message: 'La note est obligatoire')]
    #[Assert\Range(
        min: 0,
        max: 20,
        notInRangeMessage: 'La note doit être entre 0 et 20'
    )]
    private ?int $note = null;

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: true)]
    #[Assert\Choice(
        choices: ['Excellent', 'Très bon', 'Bon', 'Acceptable', 'Insuffisant'],
        message: 'La qualité doit être valide'
    )]
    #[Assert\NotBlank(message: 'La qualité est obligatoire')]
    private ?string $qualite = null;

    public function getQualite(): ?string
    {
        return $this->qualite;
    }

    public function setQualite(?string $qualite): self
    {
        $this->qualite = $qualite;
        return $this;
    }

    #[ORM\Column(type: 'string', nullable: true)]
    #[Assert\Length(
        max: 500,
        maxMessage: 'Le commentaire ne doit pas dépasser 500 caractères'
    )]
    #[Assert\NotBlank(message: 'Le commentaire est obligatoire')]
    private ?string $commentaire = null;

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;
        return $this;
    }

    #[ORM\Column(type: 'date', nullable: true)]
    #[Assert\LessThanOrEqual(
        'today',
        message: 'La date d\'évaluation ne peut pas être dans le futur'
    )]
    #[Assert\NotBlank(message: 'La date d\'évaluation est obligatoire')]
    private ?\DateTimeInterface $date_evaluation = null;

    public function getDate_evaluation(): ?\DateTimeInterface
    {
        return $this->date_evaluation;
    }

    public function setDate_evaluation(?\DateTimeInterface $date_evaluation): self
    {
        $this->date_evaluation = $date_evaluation;
        return $this;
    }

    // Aliases for Symfony form compatibility (camelCase)
    public function getDateEvaluation(): ?\DateTimeInterface
    {
        return $this->date_evaluation;
    }

    public function setDateEvaluation(?\DateTimeInterface $date_evaluation): self
    {
        $this->date_evaluation = $date_evaluation;
        return $this;
    }

}
