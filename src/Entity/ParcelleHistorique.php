<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'parcelle_historique')]
class ParcelleHistorique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private ?int $parcelle_id = null;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    private ?string $type_action = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $culture_id = null;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    private ?string $culture_nom = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $type_culture = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $surface = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $etat_avant = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $etat_apres = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private ?\DateTimeInterface $date_action = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $quantite_recolte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParcelleId(): ?int
    {
        return $this->parcelle_id;
    }

    public function setParcelleId(int $parcelle_id): static
    {
        $this->parcelle_id = $parcelle_id;

        return $this;
    }

    public function getTypeAction(): ?string
    {
        return $this->type_action;
    }

    public function setTypeAction(string $type_action): static
    {
        $this->type_action = $type_action;

        return $this;
    }

    public function getCultureId(): ?int
    {
        return $this->culture_id;
    }

    public function setCultureId(?int $culture_id): static
    {
        $this->culture_id = $culture_id;

        return $this;
    }

    public function getCultureNom(): ?string
    {
        return $this->culture_nom;
    }

    public function setCultureNom(string $culture_nom): static
    {
        $this->culture_nom = $culture_nom;

        return $this;
    }

    public function getTypeCulture(): ?string
    {
        return $this->type_culture;
    }

    public function setTypeCulture(?string $type_culture): static
    {
        $this->type_culture = $type_culture;

        return $this;
    }

    public function getSurface(): ?float
    {
        return $this->surface;
    }

    public function setSurface(?float $surface): static
    {
        $this->surface = $surface;

        return $this;
    }

    public function getEtatAvant(): ?string
    {
        return $this->etat_avant;
    }

    public function setEtatAvant(?string $etat_avant): static
    {
        $this->etat_avant = $etat_avant;

        return $this;
    }

    public function getEtatApres(): ?string
    {
        return $this->etat_apres;
    }

    public function setEtatApres(?string $etat_apres): static
    {
        $this->etat_apres = $etat_apres;

        return $this;
    }

    public function getDateAction(): ?\DateTime
    {
        return $this->date_action;
    }

    public function setDateAction(\DateTime $date_action): static
    {
        $this->date_action = $date_action;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantiteRecolte(): ?float
    {
        return $this->quantite_recolte;
    }

    public function setQuantiteRecolte(?float $quantite_recolte): static
    {
        $this->quantite_recolte = $quantite_recolte;

        return $this;
    }

}
