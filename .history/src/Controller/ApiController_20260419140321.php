// src/Controller/ApiController.php


#[Route('/api/stats', name: 'api_stats')]
public function getStats(ProduitRepository $produitRepo, StockRepository $stockRepo): JsonResponse
{
    $produits = $produitRepo->findAll();
    $stats = [];
    
    // Par catégorie
    $parCategorie = [];
    foreach ($produits as $p) {
        $cat = $p->getCategorie() ?? 'Autre';
        $parCategorie[$cat] = ($parCategorie[$cat] ?? 0) + 1;
    }
    
    // Valeur totale du stock
    $valeurTotale = 0;
    foreach ($produits as $p) {
        $stock = $p->getStockActuel();
        if ($stock) {
            $valeurTotale += $p->getPrixUnitaire() * $stock->getQuantiteActuelle();
        }
    }
    
    // Top produits par stock
    $topStocks = $stockRepo->findBy([], ['quantiteActuelle' => 'DESC'], 5);
    
    return $this->json([
        'par_categorie' => $parCategorie,
        'valeur_totale' => $valeurTotale,
        'nb_produits' => count($produits),
        'top_stocks' => array_map(fn($s) => [
            'nom' => $s->getProduit()->getNom(),
            'quantite' => $s->getQuantiteActuelle()
        ], $topStocks)
    ]);
}