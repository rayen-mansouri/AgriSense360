<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'culture')]
class Culture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100)]
    private string $nom = '';

    #[ORM\Column(type: 'string', length: 80, name: 'type_Culture', nullable: true)]
    private ?string $typeCulture = null;

    #[ORM\Column(type: 'date', name: 'date_Plantation', nullable: true)]
    private ?\DateTimeInterface $datePlantation = null;

    #[ORM\Column(type: 'date', name: 'date_Recolte', nullable: true)]
    private ?\DateTimeInterface $dateRecolte = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $etat = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $surface = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $img = null;

    #[ORM\ManyToOne(targetEntity: Parcelle::class, inversedBy: 'cultures')]
    #[ORM\JoinColumn(name: 'parcelle_Id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private Parcelle $parcelle;

    /**
     * IA-computed harvest quantity in kg.
     */
    #[ORM\Column(name: 'quantite_recolte', type: 'float', nullable: true)]
    private ?float $quantiteRecolte = null;

    /**
     * IA quality score 0-100.
     */
    #[ORM\Column(name: 'ia_score', type: 'float', nullable: true)]
    private ?float $iaScore = null;

    public function getId(): ?int { return $this->id; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $v): self { $this->nom = $v; return $this; }

    public function getTypeCulture(): ?string { return $this->typeCulture; }
    public function setTypeCulture(?string $v): self { $this->typeCulture = $v; return $this; }

    public function getDatePlantation(): ?\DateTimeInterface { return $this->datePlantation; }
    public function setDatePlantation(?\DateTimeInterface $v): self { $this->datePlantation = $v; return $this; }

    public function getDateRecolte(): ?\DateTimeInterface { return $this->dateRecolte; }
    public function setDateRecolte(?\DateTimeInterface $v): self { $this->dateRecolte = $v; return $this; }

    public function getEtat(): ?string { return $this->etat; }
    public function setEtat(?string $v): self { $this->etat = $v; return $this; }

    public function getSurface(): ?float { return $this->surface; }
    public function setSurface(?float $v): self { $this->surface = $v; return $this; }

    public function getImg(): ?string { return $this->img; }
    public function setImg(?string $v): self { $this->img = $v; return $this; }

    public function getParcelle(): Parcelle { return $this->parcelle; }
    public function setParcelle(Parcelle $v): self { $this->parcelle = $v; return $this; }

    public function getQuantiteRecolte(): ?float { return $this->quantiteRecolte; }
    public function setQuantiteRecolte(?float $v): self { $this->quantiteRecolte = $v; return $this; }

    public function getIaScore(): ?float { return $this->iaScore; }
    public function setIaScore(?float $v): self { $this->iaScore = $v; return $this; }

    public function isReadyToHarvest(): bool
    {
        if (!$this->dateRecolte) return false;
        $today = new \DateTime('today');
        $dr    = \DateTime::createFromInterface($this->dateRecolte)->setTime(0, 0, 0);
        $diff  = (int) $today->diff($dr)->days * ($dr >= $today ? 1 : -1);
        return $diff <= 10;
    }

    public function getDaysLate(): int
    {
        if (!$this->dateRecolte) return 0;
        $today = new \DateTime('today');
        $dr    = \DateTime::createFromInterface($this->dateRecolte)->setTime(0, 0, 0);
        if ($dr >= $today) return 0;
        return (int) $dr->diff($today)->days;
    }
}

