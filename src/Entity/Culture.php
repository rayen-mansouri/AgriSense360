<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'culture')]
class Culture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $type_culture = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_plantation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_recolte = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $etat = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $surface = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $img = null;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private ?int $parcelle_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

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

    public function getDatePlantation(): ?\DateTime
    {
        return $this->date_plantation;
    }

    public function setDatePlantation(?\DateTime $date_plantation): static
    {
        $this->date_plantation = $date_plantation;

        return $this;
    }

    public function getDateRecolte(): ?\DateTime
    {
        return $this->date_recolte;
    }

    public function setDateRecolte(?\DateTime $date_recolte): static
    {
        $this->date_recolte = $date_recolte;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): static
    {
        $this->etat = $etat;

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

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): static
    {
        $this->img = $img;

        return $this;
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

}
