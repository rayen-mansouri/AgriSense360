<?php
// tests/Service/StockManagerTest.php

namespace App\Tests\Service;

use App\Entity\Stock;
use App\Service\StockManager;
use PHPUnit\Framework\TestCase;

class StockManagerTest extends TestCase
{
    private StockManager $stockManager;
    private Stock $stock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stockManager = new StockManager();
        $this->stock = new Stock();
    }

    // ==================== RÈGLE 1: QUANTITÉ NON NÉGATIVE ====================
    
    public function testValidStockWithPositiveQuantity(): void
    {
        // Arrange
        $this->stock->setQuantiteActuelle(100);
        
        // Act & Assert
        $this->assertTrue($this->stockManager->validate($this->stock));
    }

    public function testValidStockWithZeroQuantity(): void
    {
        // Arrange
        $this->stock->setQuantiteActuelle(0);
        
        // Act & Assert
        $this->assertTrue($this->stockManager->validate($this->stock));
    }

    public function testInvalidStockWithNegativeQuantity(): void
    {
        // Assert - On s'attend à une exception
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('La quantité ne peut pas être négative');
        
        // Arrange
        $this->stock->setQuantiteActuelle(-10);
        
        // Act
        $this->stockManager->validate($this->stock);
    }

    // ==================== RÈGLE 2: SEUIL <= QUANTITÉ ====================

    public function testValidStockWithSeuilLessThanQuantity(): void
    {
        // Arrange
        $this->stock->setQuantiteActuelle(100);
        $this->stock->setSeuilAlerte(20);
        
        // Act & Assert
        $this->assertTrue($this->stockManager->validate($this->stock));
    }

    public function testValidStockWithSeuilEqualToQuantity(): void
    {
        // Arrange
        $this->stock->setQuantiteActuelle(50);
        $this->stock->setSeuilAlerte(50);
        
        // Act & Assert
        $this->assertTrue($this->stockManager->validate($this->stock));
    }

    public function testInvalidStockWithSeuilGreaterThanQuantity(): void
    {
        // Assert - On s'attend à une exception
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Le seuil d\'alerte ne peut pas dépasser la quantité disponible');
        
        // Arrange
        $this->stock->setQuantiteActuelle(30);
        $this->stock->setSeuilAlerte(50);
        
        // Act
        $this->stockManager->validate($this->stock);
    }

    public function testValidStockWithNoSeuil(): void
    {
        // Arrange
        $this->stock->setQuantiteActuelle(100);
        $this->stock->setSeuilAlerte(null);
        
        // Act & Assert
        $this->assertTrue($this->stockManager->validate($this->stock));
    }

    // ==================== TEST DE LA MÉTHODE isEnAlerte ====================

    public function testStockInAlert(): void
    {
        // Arrange
        $this->stock->setQuantiteActuelle(10);
        $this->stock->setSeuilAlerte(20);
        
        // Act & Assert
        $this->assertTrue($this->stockManager->isEnAlerte($this->stock));
    }

    public function testStockNotInAlert(): void
    {
        // Arrange
        $this->stock->setQuantiteActuelle(50);
        $this->stock->setSeuilAlerte(20);
        
        // Act & Assert
        $this->assertFalse($this->stockManager->isEnAlerte($this->stock));
    }

    public function testStockWithNoSeuilNotInAlert(): void
    {
        // Arrange
        $this->stock->setQuantiteActuelle(10);
        $this->stock->setSeuilAlerte(null);
        
        $this->assertFalse($this->stockManager->isEnAlerte($this->stock));
    }

    public function testStockWhenQuantityEqualsSeuil(): void
    {
        $this->stock->setQuantiteActuelle(20);
        $this->stock->setSeuilAlerte(20);
        
        $this->assertTrue($this->stockManager->isEnAlerte($this->stock));
    }
}