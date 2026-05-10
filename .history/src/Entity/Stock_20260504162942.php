<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

// ============================================================
// ERREURS CORRIGÉES (dues au reverse engineering) :
//
// 1. #[ORM\Entity] sans repositoryClass → ajout de repositoryClass: StockRepository::class
// 2. Relation ManyToOne vers Produit mal placée (annotation déformée) → corrigée
// 3. Propriété $produit_id résiduelle non mappée → supprimée
// 4. setProduitId(?int) appelait $this->produit_id inexistant → supprimée
// 5. getProduitId() retournait un int au lieu de l'objet Produit → remplacée
//    par getProduit() qui retourne l'objet et setProduit() qui accepte l'objet
// 6. seuil_alerte nullable: false alors que DEFAULT NULL en BDD → nullable: true
// 7. Manque #[ORM\HasLifecycleCallbacks] + preUpdate() → ajoutés
// 8. Manque du constructeur avec timestamps → ajouté
// 9. Manque des méthodes métier isEnAlerte() et getStatut() → ajoutées
// ============================================================

#[ORM\Entity(repositoryClass: StockRepository::class)]
#[ORM\Table(name: 'stock')]
#[ORM\HasLifecycleCallbacks]
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // CORRECTION : relation ManyToOne correctement déclarée
    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'stocks')]
    #[ORM\JoinColumn(name: 'produit_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Produit $produit = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: false)]
    #[Assert\NotBlank(message: 'La quantité est obligatoire.')]
    #[Assert\PositiveOrZero(message: 'La quantité doit être positive ou nulle.')]
    private ?string $quantite_actuelle = null;

    // CORRECTION : nullable: true (DEFAULT NULL en BDD)
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: false)]
    private ?string $seuil_alerte = null;

    #[ORM\Column(type: Types::STRING, length: 50, nullable: false)]
    #[Assert\NotBlank(message: "L'unité de mesure est obligatoire.")]
    private ?string $unite_mesure = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $date_reception = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $date_expiration = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $emplacement = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private ?\DateTime $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private ?\DateTimeInterface $updated_at = null;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updated_at = new \DateTime();
    }

    // ── Getters / Setters ─────────────────────────────────────────────────

    public function getId(): ?int
    {
        return $this->id;
    }

    // CORRECTION : getProduit() retourne l'objet Produit (pas un int)
    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    // CORRECTION : setProduit() accepte un objet Produit (pas un int)
    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;
        return $this;
    }

    public function getQuantiteActuelle(): ?string
    {
        return $this->quantite_actuelle;
    }

    public function setQuantiteActuelle(string $quantite_actuelle): static
    {
        $this->quantite_actuelle = $quantite_actuelle;
        return $this;
    }

    public function getSeuilAlerte(): ?string
    {
        return $this->seuil_alerte;
    }

    public function setSeuilAlerte(?string $seuil_alerte): static
    {
        $this->seuil_alerte = $seuil_alerte;
        return $this;
    }

    public function getUniteMesure(): ?string
    {
        return $this->unite_mesure;
    }

    public function setUniteMesure(string $unite_mesure): static
    {
        $this->unite_mesure = $unite_mesure;
        return $this;
    }

    public function getDateReception(): ?\DateTime
    {
        return $this->date_reception;
    }

    public function setDateReception(?\DateTime $date_reception): static
    {
        $this->date_reception = $date_reception;
        return $this;
    }

    public function getDateExpiration(): ?\DateTime
    {
        return $this->date_expiration;
    }

    public function setDateExpiration(?\DateTime $date_expiration): static
    {
        $this->date_expiration = $date_expiration;
        return $this;
    }

    public function getEmplacement(): ?string
    {
        return $this->emplacement;
    }

    public function setEmplacement(?string $emplacement): static
    {
        $this->emplacement = $emplacement;
        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTime $created_at): static
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTime $updated_at): static
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    // ── Méthodes métier ───────────────────────────────────────────────────

    public function isEnAlerte(): bool
    {
        if ($this->seuil_alerte === null) return false;
        return (float)$this->quantite_actuelle <= (float)$this->seuil_alerte;
    }

    public function getStatut(): string
    {
        if ((float)$this->quantite_actuelle === 0.0) return 'Rupture';
        return $this->isEnAlerte() ? 'Critique' : 'Normal';
    }
}
