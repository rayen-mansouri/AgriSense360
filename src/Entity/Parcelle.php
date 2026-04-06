<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'parcelle')]
class Parcelle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::FLOAT, nullable: false)]
    private ?float $surface = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $localisation = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $type_sol = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $statut = null;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private ?int $surface_restant = null;

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

    public function getSurface(): ?float
    {
        return $this->surface;
    }

    public function setSurface(float $surface): static
    {
        $this->surface = $surface;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(?string $localisation): static
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getTypeSol(): ?string
    {
        return $this->type_sol;
    }

    public function setTypeSol(?string $type_sol): static
    {
        $this->type_sol = $type_sol;

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

    public function getSurfaceRestant(): ?int
    {
        return $this->surface_restant;
    }

    public function setSurfaceRestant(int $surface_restant): static
    {
        $this->surface_restant = $surface_restant;

        return $this;
    }

}
