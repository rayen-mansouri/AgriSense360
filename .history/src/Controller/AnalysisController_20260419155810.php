// Dans src/Controller/AnalysisController.php

#[Route('/analyse', name: 'analyse_complete')]
public function completeAnalysis(
    ProduitRepository $produitRepo,
    AdvancedProductQualityService $qualityService,
    AdvancedProfitabilityService $profitabilityService
): Response {
    $produits = $produitRepo->findAll();
    $qualites = [];
    $rentabilite = [];
    
    foreach ($produits as $produit) {
        $qualites[] = $qualityService->analyzeQuality($produit);
        $rentabilite[] = $profitabilityService->calculateProfitability($produit);
    }
    
    usort($qualites, fn($a, $b) => $a['score_global'] <=> $b['score_global']);
    usort($rentabilite, fn($a, $b) => $b['benefice_net'] <=> $a['benefice_net']);
    
    $prixMoyen = array_sum(array_map(fn($p) => $p->getPrixUnitaire(), $produits)) / max(1, count($produits));
    
    return $this->render('ai/complete_analysis.html.twig', [
        'produits' => $produits,
        'categories' => $produitRepo->findAllCategories(),
        'qualites' => $qualites,
        'rentabilite' => $rentabilite,
        'prixMoyen' => round($prixMoyen, 2)
    ]);
}

#[Route('/api/similar/{id}', name: 'api_similar')]
public function similar(int $id, ProduitRepository $produitRepo, AdvancedSimilarProductsService $similarService): JsonResponse
{
    $produit = $produitRepo->find($id);
    return $this->json($similarService->recommend($produit));
}

#[Route('/api/ai/classify', name: 'api_ai_classify', methods: ['POST'])]
public function classify(Request $request, AIKNNClassifierService $classifier): JsonResponse
{
    $data = json_decode($request->getContent(), true);
    
    // Créer un produit temporaire pour la prédiction
    $tempProduit = new Produit();
    $tempProduit->setNom($data['nom'] ?? '');
    $tempProduit->setPrixUnitaire($data['prix'] ?? 50);
    
    return $this->json($classifier->predict($tempProduit));
}

#[Route('/api/ai/anomalies', name: 'api_ai_anomalies')]
public function anomalies(AIPriceAnomalyService $anomalyService): JsonResponse
{
    return $this->json($anomalyService->detectAnomalies());
}