<?php
namespace App\Tests\Functional\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GestionControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;
    private $produitRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->entityManager = static::getContainer()->get('doctrine')->getManager();
        $this->produitRepository = static::getContainer()->get(ProduitRepository::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }

    // Test création produit (simulé sans formulaire)
    public function testProduitNewPageIsAccessible(): void
    {
        $this->client->request('GET', '/produit/nouveau');
        
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Nouveau Produit');
    }

    public function testProduitShowPageForExistingProduct(): void
    {
        // Récupérer un produit existant
        $produit = $this->produitRepository->findOneBy([]);
        
        if ($produit) {
            $this->client->request('GET', '/produit/' . $produit->getId());
            $this->assertResponseIsSuccessful();
        } else {
            $this->markTestSkipped('Aucun produit en base de données');
        }
    }

    public function testProduitShowForNonExistentProduct(): void
    {
        $this->client->request('GET', '/produit/99999');
        
        // Devrait rediriger avec un flash message
        $this->assertResponseRedirects('/home');
    }

    public function testProduitEditPageForExistingProduct(): void
    {
        $produit = $this->produitRepository->findOneBy([]);
        
        if ($produit) {
            $this->client->request('GET', '/produit/' . $produit->getId() . '/edit');
            $this->assertResponseIsSuccessful();
            $this->assertSelectorTextContains('h1', 'Modifier le Produit');
        } else {
            $this->markTestSkipped('Aucun produit en base de données');
        }
    }

    // Test recherche par code-barres API
    public function testSearchByBarcodeWithValidSku(): void
    {
        $produit = $this->produitRepository->findOneBy(['sku' => $this->getValidSku()]);
        
        if ($produit && $produit->getSku()) {
            $this->client->request('GET', '/api/produit/recherche?code=' . $produit->getSku());
            
            $this->assertResponseIsSuccessful();
            $responseData = json_decode($this->client->getResponse()->getContent(), true);
            
            $this->assertArrayHasKey('id', $responseData);
            $this->assertArrayHasKey('nom', $responseData);
            $this->assertArrayHasKey('sku', $responseData);
        } else {
            $this->markTestSkipped('Aucun produit avec SKU valide');
        }
    }

    public function testSearchByBarcodeWithValidId(): void
    {
        $produit = $this->produitRepository->findOneBy([]);
        
        if ($produit) {
            $this->client->request('GET', '/api/produit/recherche?code=' . $produit->getId());
            
            $this->assertResponseIsSuccessful();
            $responseData = json_decode($this->client->getResponse()->getContent(), true);
            
            $this->assertEquals($produit->getId(), $responseData['id']);
        } else {
            $this->markTestSkipped('Aucun produit en base de données');
        }
    }

    public function testSearchByBarcodeWithInvalidCode(): void
    {
        $this->client->request('GET', '/api/produit/recherche?code=INVALID_CODE_12345');
        
        $this->assertResponseStatusCodeSame(404);
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        
        $this->assertArrayHasKey('error', $responseData);
        $this->assertEquals('Produit non trouvé', $responseData['error']);
    }

    // Test scanner page
    public function testScannerPageIsAccessible(): void
    {
        $this->client->request('GET', '/scannerback');
        
        $this->assertResponseIsSuccessful();
    }

    // Méthode utilitaire pour récupérer un SKU valide
    private function getValidSku(): ?string
    {
        $produit = $this->produitRepository->findOneBy(['sku' => $this->getValidSkuCriteria()]);
        return $produit ? $produit->getSku() : null;
    }

    private function getValidSkuCriteria(): array
    {
        return ['sku' => 'TEST-SKU-001'];
    }
}
