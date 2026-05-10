<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'produit')]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 100)]
    #[Assert\NotBlank(message: 'La catégorie est obligatoire.')]
    private ?string $categorie = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\NotBlank(message: 'Le nom du produit est obligatoire.')]
    #[Assert\Length(min: 3, minMessage: 'Le nom doit contenir au moins 3 caractères.')]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank(message: 'Le prix unitaire est obligatoire.')]
    #[Assert\Positive(message: 'Le prix doit être positif.')]
    private ?string $prix_unitaire = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $photo_url = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $barcode_url = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $agriculteur_id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
private ?string $barcode_url = null;

#[ORM\Column(type: Types::TEXT, nullable: true)]
private ?string $qr_code_url = null;

#[ORM\Column(length: 50, nullable: true)]
private ?string $sku = null;

    // Relation OneToMany avec Stock
    #[ORM\OneToMany(targetEntity: Stock::class, mappedBy: 'produit')]
    private Collection $stocks;

    public function __construct()
    {
        $this->stocks = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    // ──────────────────────────────────────────────────────────────────────────
    // Getters et Setters
    // ──────────────────────────────────────────────────────────────────────────

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;
        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getPrixUnitaire(): ?string
    {
        return $this->prix_unitaire;
    }

    public function setPrixUnitaire(string $prix_unitaire): static
    {
        $this->prix_unitaire = $prix_unitaire;
        return $this;
    }

    public function getPhotoUrl(): ?string
    {
        return $this->photo_url;
    }

    public function setPhotoUrl(?string $photo_url): static
    {
        $this->photo_url = $photo_url;
        return $this;
    }

    public function getBarcodeUrl(): ?string
    {
        return $this->barcode_url;
    }

    public function setBarcodeUrl(?string $barcode_url): static
    {
        $this->barcode_url = $barcode_url;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    public function getAgriculteurId(): ?int
    {
        return $this->agriculteur_id;
    }

    public function setAgriculteurId(int $agriculteur_id): static
    {
        $this->agriculteur_id = $agriculteur_id;
        return $this;
    }
    public function getQrCodeUrl(): ?string
    {
     return $this->qr_code_url;
    }

    public function setQrCodeUrl(?string $qr_code_url): static
    {
     $this->qr_code_url = $qr_code_url;
        return $this;
    }

    // ──────────────────────────────────────────────────────────────────────────
    // Méthodes de gestion des stocks
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * @return Collection<int, Stock>
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(Stock $stock): static
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks->add($stock);
            $stock->setProduit($this);
        }
        return $this;
    }

    public function removeStock(Stock $stock): static
    {
        if ($this->stocks->removeElement($stock)) {
            if ($stock->getProduit() === $this) {
                $stock->setProduit(null);
            }
        }
        return $this;
    }

    public function getStockActuel(): ?Stock
    {
        if ($this->stocks->count() > 0) {
            return $this->stocks->first();
        }
        return null;
    }
}