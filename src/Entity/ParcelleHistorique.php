<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'parcelle_historique')]
class ParcelleHistorique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'parcelle_id')]
    private int $parcelleId;

    #[ORM\Column(name: 'type_action', length: 50)]
    private string $typeAction;

    #[ORM\Column(name: 'culture_id', nullable: true)]
    private ?int $cultureId = null;

    #[ORM\Column(name: 'culture_nom', length: 100, nullable: true)]
    private ?string $cultureNom = null;

    #[ORM\Column(name: 'type_culture', length: 50, nullable: true)]
    private ?string $typeCulture = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $surface = null;

    #[ORM\Column(name: 'etat_avant', length: 50, nullable: true)]
    private ?string $etatAvant = null;

    #[ORM\Column(name: 'etat_apres', length: 50, nullable: true)]
    private ?string $etatApres = null;

    #[ORM\Column(name: 'date_action', type: 'datetime')]
    private \DateTimeInterface $dateAction;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: 'quantite_recolte', type: 'float', nullable: true)]
    private ?float $quantiteRecolte = null;

    public function __construct()
    {
        $this->dateAction = new \DateTime();
    }

    public function getId(): ?int { return $this->id; }

    public function getParcelleId(): int { return $this->parcelleId; }
    public function setParcelleId(int $v): self { $this->parcelleId = $v; return $this; }

    public function getTypeAction(): string { return $this->typeAction; }
    public function setTypeAction(string $v): self { $this->typeAction = $v; return $this; }

    public function getCultureId(): ?int { return $this->cultureId; }
    public function setCultureId(?int $v): self { $this->cultureId = $v; return $this; }

    public function getCultureNom(): ?string { return $this->cultureNom; }
    public function setCultureNom(?string $v): self { $this->cultureNom = $v; return $this; }

    public function getTypeCulture(): ?string { return $this->typeCulture; }
    public function setTypeCulture(?string $v): self { $this->typeCulture = $v; return $this; }

    public function getSurface(): ?float { return $this->surface; }
    public function setSurface(?float $v): self { $this->surface = $v; return $this; }

    public function getEtatAvant(): ?string { return $this->etatAvant; }
    public function setEtatAvant(?string $v): self { $this->etatAvant = $v; return $this; }

    public function getEtatApres(): ?string { return $this->etatApres; }
    public function setEtatApres(?string $v): self { $this->etatApres = $v; return $this; }

    public function getDateAction(): \DateTimeInterface { return $this->dateAction; }
    public function setDateAction(\DateTimeInterface $v): self { $this->dateAction = $v; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $v): self { $this->description = $v; return $this; }

    public function getQuantiteRecolte(): ?float { return $this->quantiteRecolte; }
    public function setQuantiteRecolte(?float $v): self { $this->quantiteRecolte = $v; return $this; }

    public function getTypeIcon(): string
    {
        return match($this->typeAction) {
            'CULTURE_AJOUTEE'   => '🌱',
            'CULTURE_MODIFIEE'  => '✏️',
            'CULTURE_SUPPRIMEE' => '🗑',
            'RECOLTE'           => '🌾',
            default             => '📋',
        };
    }

    public function getTypeLabelFr(): string
    {
        return match($this->typeAction) {
            'CULTURE_AJOUTEE'   => 'Culture ajoutée',
            'CULTURE_MODIFIEE'  => 'Culture modifiée',
            'CULTURE_SUPPRIMEE' => 'Culture supprimée',
            'RECOLTE'           => 'Récolte effectuée',
            default             => $this->typeAction,
        };
    }

    public function getActionCssClass(): string
    {
        return match($this->typeAction) {
            'CULTURE_AJOUTEE'   => 'hist-green',
            'CULTURE_MODIFIEE'  => 'hist-amber',
            'CULTURE_SUPPRIMEE' => 'hist-red',
            'RECOLTE'           => 'hist-teal',
            default             => 'hist-blue',
        };
    }
}
