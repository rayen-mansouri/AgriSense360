<?php
namespace App\tests\Unit\Entity;

use App\Entity\Produit;
use App\Entity\Stock;
use PHPUnit\Framework\TestCase;
use DateTime;

class ProduitTest extends TestCase
{
    private Produit $produit;

    protected function setUp(): void
    {
        parent::setUp();
        $this->produit = new Produit();
    }

    // Test des getters/setters de base
    public function testSetAndGetNom(): void
    {
        $nom = "Engrais NPK 15-15-15";
        $this->produit->setNom($nom);
        $this->assertEquals($nom, $this->produit->getNom());
    }

    public function testSetAndGetCategorie(): void
    {
        $categorie = "Engrais";
        $this->produit->setCategorie($categorie);
        $this->assertEquals($categorie, $this->produit->getCategorie());
    }

    public function testSetAndGetDescription(): void
    {
        $description = "Engrais complet pour toutes cultures";
        $this->produit->setDescription($description);
        $this->assertEquals($description, $this->produit->getDescription());
    }

    public function testSetAndGetPrixUnitaire(): void
    {
        $prix = "150.50";
        $this->produit->setPrixUnitaire($prix);
        $this->assertEquals($prix, $this->produit->getPrixUnitaire());
    }

    public function testSetAndGetPhotoUrl(): void
    {
        $url = "uploads/photos/photo123.jpg";
        $this->produit->setPhotoUrl($url);
        $this->assertEquals($url, $this->produit->getPhotoUrl());
    }

    public function testSetAndGetSku(): void
    {
        $sku = "PROD-001";
        $this->produit->setSku($sku);
        $this->assertEquals($sku, $this->produit->getSku());
    }

    public function testSetAndGetBarcodeUrl(): void
    {
        $url = "uploads/barcodes/barcode123.png";
        $this->produit->setBarcodeUrl($url);
        $this->assertEquals($url, $this->produit->getBarcodeUrl());
    }

    public function testSetAndGetAgriculteurId(): void
    {
        $agriculteurId = 1;
        $this->produit->setAgriculteurId($agriculteurId);
        $this->assertEquals($agriculteurId, $this->produit->getAgriculteurId());
    }

    public function testCreatedAtIsSetOnConstruct(): void
    {
        $this->assertInstanceOf(DateTime::class, $this->produit->getCreatedAt());
    }

    public function testUpdatedAtIsSetOnConstruct(): void
    {
        $this->assertInstanceOf(DateTime::class, $this->produit->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $date = new DateTime('2024-01-01');
        $this->produit->setUpdatedAt($date);
        $this->assertEquals($date, $this->produit->getUpdatedAt());
    }

    // Test de la relation avec Stock
    public function testAddStock(): void
    {
        $stock = new Stock();
        $stock->setQuantiteActuelle("100");
        
        $this->produit->addStock($stock);
        
        $this->assertCount(1, $this->produit->getStocks());
        $this->assertSame($this->produit, $stock->getProduit());
    }

    public function testRemoveStock(): void
    {
        $stock = new Stock();
        $stock->setQuantiteActuelle("100");
        
        $this->produit->addStock($stock);
        $this->assertCount(1, $this->produit->getStocks());
        
        $this->produit->removeStock($stock);
        $this->assertCount(0, $this->produit->getStocks());
    }

    public function testGetStockActuelWithNoStock(): void
    {
        $this->assertNull($this->produit->getStockActuel());
    }

    public function testGetStockActuelWithStock(): void
    {
        $stock = new Stock();
        $stock->setQuantiteActuelle("100");
        $this->produit->addStock($stock);
        
        $this->assertSame($stock, $this->produit->getStockActuel());
    }

    public function testGetStockActuelReturnsFirstStock(): void
    {
        $stock1 = new Stock();
        $stock1->setQuantiteActuelle("50");
        
        $stock2 = new Stock();
        $stock2->setQuantiteActuelle("100");
        
        $this->produit->addStock($stock1);
        $this->produit->addStock($stock2);
        
        $this->assertSame($stock1, $this->produit->getStockActuel());
    }
}
