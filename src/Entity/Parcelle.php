<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'parcelle')]
class Parcelle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100)]
    private string $nom = '';

    #[ORM\Column(type: 'float')]
    private float $surface = 0;

    #[ORM\Column(type: 'float', name: 'surface_restant')]
    private float $surfaceRestant = 0;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $localisation = null;

    #[ORM\Column(type: 'string', length: 80, name: 'type_sol', nullable: true)]
    private ?string $typeSol = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $statut = 'Libre';

    #[ORM\OneToMany(mappedBy: 'parcelle', targetEntity: Culture::class, cascade: ['remove'], fetch: 'EAGER')]
    private Collection $cultures;

    public function __construct()
    {
        $this->cultures = new ArrayCollection();
        $this->statut   = 'Libre';
    }

    public function getId(): ?int { return $this->id; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $v): self { $this->nom = $v; return $this; }

    public function getSurface(): float { return $this->surface; }
    public function setSurface(float $v): self { $this->surface = $v; return $this; }

    public function getSurfaceRestant(): float { return $this->surfaceRestant; }
    public function setSurfaceRestant(float $v): self { $this->surfaceRestant = $v; return $this; }

    public function getLocalisation(): ?string { return $this->localisation; }
    public function setLocalisation(?string $v): self { $this->localisation = $v; return $this; }

    public function getTypeSol(): ?string { return $this->typeSol; }
    public function setTypeSol(?string $v): self { $this->typeSol = $v; return $this; }

    public function getStatut(): ?string { return $this->statut; }
    public function setStatut(?string $v): self { $this->statut = $v; return $this; }

    public function getCultures(): Collection { return $this->cultures; }

    public function getTauxOccupation(): float
    {
        if ($this->surface <= 0) return 0;
        return round((($this->surface - $this->surfaceRestant) / $this->surface) * 100, 1);
    }
}

