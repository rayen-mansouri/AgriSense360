<?php
namespace App\ests\Repository;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProduitRepositoryTest extends KernelTestCase
{
    private ?ProduitRepository $repository = null;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->repository = static::getContainer()->get(ProduitRepository::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->repository = null;
    }

    public function testFindFilteredWithoutFilters(): void
    {
        $results = $this->repository->findFiltered();
        
        $this->assertIsArray($results);
    }

    public function testFindFilteredWithSearch(): void
    {
        $results = $this->repository->findFiltered('engrais');
        
        $this->assertIsArray($results);
    }

    public function testFindFilteredWithCategory(): void
    {
        $results = $this->repository->findFiltered('', 'Engrais');
        
        $this->assertIsArray($results);
    }

    public function testFindFilteredWithSort(): void
    {
        $results = $this->repository->findFiltered('', '', 'nom', 'asc');
        
        $this->assertIsArray($results);
    }

    public function testFindAllCategories(): void
    {
        $categories = $this->repository->findAllCategories();
        
        $this->assertIsArray($categories);
    }

    public function testFindByCategorie(): void
    {
        $results = $this->repository->findByCategorie('Engrais');
        
        $this->assertIsArray($results);
        
        foreach ($results as $produit) {
            $this->assertEquals('Engrais', $produit->getCategorie());
        }
    }

    public function testSearchByNom(): void
    {
        $results = $this->repository->searchByNom('engrais');
        
        $this->assertIsArray($results);
    }
}