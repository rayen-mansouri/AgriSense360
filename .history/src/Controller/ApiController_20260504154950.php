<?php
namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Repository\StockRepository;
use App\Service\ExchangeRateService;
use App\Service\OpenFoodFactsService;
use App\Service\CommodityPriceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    
    
    #[Route('/api/openfoodfacts/{barcode}', name: 'api_openfoodfacts')]
    public function openFoodFacts(string $barcode, OpenFoodFactsService $service): JsonResponse
    {
        $product = $service->getProductByBarcode($barcode);
        return $this->json($product ?: ['error' => 'Non trouvé']);
    }
    
    #[Route('/api/exchange/rates', name: 'api_exchange_rates')]
    public function exchangeRates(ExchangeRateService $service): JsonResponse
    {
        return $this->json($service->getRates());
    }
    
    #[Route('/api/exchange/convert', name: 'api_exchange_convert')]
    public function exchangeConvert(Request $request, ExchangeRateService $service): JsonResponse
    {
        $amount = $request->query->get('amount', 0);
        $currency = $request->query->get('currency', 'EUR');
        return $this->json(['converted' => $service->convert($amount, $currency)]);
    }
#[Route('/stats', name: 'stats_dashboard')]
    public function statsDashboard(): Response
    {
        return $this->render('templates/dashboard.html.twig');
    }



#[Route('/scan', name: 'api_openfoodfacts_view')]
public function scanView(): Response
{
    return $this->render('api/openfoodfacts.html.twig');
}

#[Route('/exchange', name: 'api_exchange_view')]
public function exchangeView(): Response
{
    return $this->render('api/exchange.html.twig');
}

#[Route('/export', name: 'export_excel_view')]
public function exportView(): Response
{
    return $this->render('export/index.html.twig');
}
#[Route('/api/commodity/price', name: 'api_commodity_price')]
public function commodityPrice(Request $request, CommodityPriceService $service): JsonResponse
{
    $commodity = $request->query->get('commodity', 'WHEAT');
    $price = $service->getPrice($commodity);
    
    if ($price) {
        return $this->json($price);
    }
    
    return $this->json(['error' => 'Prix non disponible'], 404);
}
#[Route('/commodity', name: 'api_commodity_view')]
public function commodityView(): Response
{
    return $this->render('api/commodity.html.twig');
}
}