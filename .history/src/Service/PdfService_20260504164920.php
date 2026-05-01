<?php
namespace App\Service;

use App\Repository\ProduitRepository;
use App\Repository\StockRepository;

/**
 * Service d'export PDF — utilise la lib mPDF (à installer via composer).
 * Génère des PDF pour : liste produits, liste stocks, rapport alertes.
 *
 * Installation : composer require mpdf/mpdf
 */
class PdfService
{

    public function __construct(
        //private ProduitRepository $produitRepo,
        private StockRepository   $stockRepo,
    ) {}

    // ── PRODUITS ──────────────────────────────────────────────────────────────

    public function generateProduits(array $produits): string
    {
        $date = (new \DateTime())->format('d/m/Y H:i');
        $rows = '';
        foreach ($produits as $p) {
            $s   = $p->getStockActuel();
            $qty = $s ? $s->getQuantiteActuelle().' '.$s->getUniteMesure() : '—';
            $statut = $s ? $s->getStatut() : 'Sans stock';
            $statutColor = match ($statut) {
                'Normal'  => '#2e7d32',
                'Critique'=> '#e65100',
                'Rupture' => '#c62828',
                default   => '#6b7b6e',
            };
            $rows .= '<tr>
                <td>'.htmlspecialchars($p->getNom()).'</td>
                <td>'.htmlspecialchars($p->getCategorie() ?? '—').'</td>
                <td style="text-align:right">'.number_format((float)$p->getPrixUnitaire(), 2, ',', ' ').' DT</td>
                <td style="text-align:center">'.htmlspecialchars($qty).'</td>
                <td style="text-align:center;color:'.$statutColor.';font-weight:bold">'.htmlspecialchars($statut).'</td>
            </tr>';
        }

        $html = $this->wrapHtml('Liste des Produits', $date, '
            <table>
                <thead><tr>
                    <th>Produit</th><th>Catégorie</th><th>Prix unitaire</th><th>Stock actuel</th><th>Statut</th>
                </tr></thead>
                <tbody>'.$rows.'</tbody>
            </table>
            <p class="footer-note">Total : '.count($produits).' produit(s) — Généré le '.$date.'</p>
        ');

        return $this->render($html, 'produits_'.date('Ymd'));
    }

    // ── STOCKS ────────────────────────────────────────────────────────────────

    public function generateStocks(array $stocks): string
    {
        $date = (new \DateTime())->format('d/m/Y H:i');
        $rows = '';
        foreach ($stocks as $s) {
            $statut = $s->getStatut();
            $statutColor = match ($statut) {
                'Normal'  => '#2e7d32',
                'Critique'=> '#e65100',
                'Rupture' => '#c62828',
                default   => '#6b7b6e',
            };
            $pct = '';
            if ($s->getSeuilAlerte() && (float)$s->getSeuilAlerte() > 0) {
                $v = round((float)$s->getQuantiteActuelle() / (float)$s->getSeuilAlerte() * 100);
                $pct = $v.'%';
            }
            $exp = $s->getDateExpiration() ? $s->getDateExpiration()->format('d/m/Y') : '—';
            $rows .= '<tr>
                <td>'.htmlspecialchars($s->getProduit()->getNom()).'</td>
                <td>'.htmlspecialchars($s->getProduit()->getCategorie() ?? '—').'</td>
                <td style="text-align:right;font-weight:bold">'.htmlspecialchars($s->getQuantiteActuelle()).'</td>
                <td style="text-align:center">'.htmlspecialchars($s->getSeuilAlerte() ?? '—').'</td>
                <td style="text-align:center">'.htmlspecialchars($s->getUniteMesure()).'</td>
                <td style="text-align:center">'.htmlspecialchars($pct).'</td>
                <td style="text-align:center">'.htmlspecialchars($s->getEmplacement() ?? '—').'</td>
                <td style="text-align:center">'.htmlspecialchars($exp).'</td>
                <td style="text-align:center;color:'.$statutColor.';font-weight:bold">'.htmlspecialchars($statut).'</td>
            </tr>';
        }

        $html = $this->wrapHtml('État des Stocks', $date, '
            <table>
                <thead><tr>
                    <th>Produit</th><th>Catégorie</th><th>Quantité</th><th>Seuil</th>
                    <th>Unité</th><th>% Seuil</th><th>Emplacement</th><th>Expiration</th><th>Statut</th>
                </tr></thead>
                <tbody>'.$rows.'</tbody>
            </table>
            <p class="footer-note">Total : '.count($stocks).' entrée(s) — Généré le '.$date.'</p>
        ');

        return $this->render($html, 'stocks_'.date('Ymd'));
    }

    // ── RAPPORT ALERTES ───────────────────────────────────────────────────────

    public function generateAlertes(): string
    {
        $date    = (new \DateTime())->format('d/m/Y H:i');
        $alertes = $this->stockRepo->findAlertes();
        $expiring = $this->stockRepo->findExpiringSoon(30);

        $rowsAlertes = '';
        foreach ($alertes as $s) {
            $color = (float)$s->getQuantiteActuelle() === 0.0 ? '#c62828' : '#e65100';
            $rowsAlertes .= '<tr>
                <td>'.htmlspecialchars($s->getProduit()->getNom()).'</td>
                <td>'.htmlspecialchars($s->getProduit()->getCategorie() ?? '—').'</td>
                <td style="text-align:right;color:'.$color.';font-weight:bold">'.htmlspecialchars($s->getQuantiteActuelle()).'</td>
                <td style="text-align:center">'.htmlspecialchars($s->getSeuilAlerte()).'</td>
                <td style="text-align:center">'.htmlspecialchars($s->getUniteMesure()).'</td>
                <td style="text-align:center">'.htmlspecialchars($s->getEmplacement() ?? '—').'</td>
            </tr>';
        }

        $rowsExp = '';
        foreach ($expiring as $s) {
            $days = (new \DateTime())->diff($s->getDateExpiration())->days;
            $color = $days <= 7 ? '#c62828' : '#e65100';
            $rowsExp .= '<tr>
                <td>'.htmlspecialchars($s->getProduit()->getNom()).'</td>
                <td style="text-align:center">'.htmlspecialchars($s->getDateExpiration()->format('d/m/Y')).'</td>
                <td style="text-align:center;color:'.$color.';font-weight:bold">'.$days.' jour(s)</td>
                <td style="text-align:center">'.htmlspecialchars($s->getQuantiteActuelle().' '.$s->getUniteMesure()).'</td>
                <td style="text-align:center">'.htmlspecialchars($s->getEmplacement() ?? '—').'</td>
            </tr>';
        }

        $content = '
            <h2 style="color:#c62828;margin-bottom:12px">⚠️ Stocks en alerte ('.count($alertes).')</h2>
            '.(!$alertes ? '<p style="color:#6b7b6e;font-style:italic">Aucune alerte de stock.</p>' : '
            <table>
                <thead><tr><th>Produit</th><th>Catégorie</th><th>Quantité</th><th>Seuil</th><th>Unité</th><th>Emplacement</th></tr></thead>
                <tbody>'.$rowsAlertes.'</tbody>
            </table>').'

            <h2 style="color:#e65100;margin:24px 0 12px">📅 Expirations dans les 30 jours ('.count($expiring).')</h2>
            '.(!$expiring ? '<p style="color:#6b7b6e;font-style:italic">Aucune expiration proche.</p>' : '
            <table>
                <thead><tr><th>Produit</th><th>Date expiration</th><th>Jours restants</th><th>Stock</th><th>Emplacement</th></tr></thead>
                <tbody>'.$rowsExp.'</tbody>
            </table>').'

            <p class="footer-note">Rapport généré le '.$date.'</p>
        ';

        $html = $this->wrapHtml('Rapport des Alertes', $date, $content);
        return $this->render($html, 'alertes_'.date('Ymd'));
    }

    // ── HELPERS ───────────────────────────────────────────────────────────────

    private function wrapHtml(string $title, string $date, string $body): string
    {
        return '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8">
        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 11px; color: #22301b; }
            .header { background: #1e3c2c; color: white; padding: 20px 30px; margin-bottom: 24px; }
            .header h1 { font-size: 20px; font-weight: 700; margin-bottom: 4px; }
            .header .meta { font-size: 10px; opacity: .75; }
            .logo { font-size: 13px; font-weight: 700; color: #ffd700; margin-bottom: 8px; }
            .content { padding: 0 30px; }
            table { width: 100%; border-collapse: collapse; margin-bottom: 16px; font-size: 10.5px; }
            thead tr { background: #f0f5e8; }
            th { padding: 8px 10px; text-align: left; font-weight: 700; font-size: 10px; text-transform: uppercase; letter-spacing: .04em; color: #2b3b1f; border-bottom: 2px solid #c8d8b0; }
            td { padding: 7px 10px; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
            tr:nth-child(even) { background: #fafcf6; }
            h2 { font-size: 14px; font-weight: 700; }
            .footer-note { font-size: 10px; color: #9aaa8a; margin-top: 12px; font-style: italic; border-top: 1px solid #e4ead8; padding-top: 10px; }
            .footer { text-align: center; font-size: 9px; color: #9aaa8a; margin-top: 30px; padding: 12px; border-top: 1px solid #e4ead8; }
        </style></head><body>
        <div class="header">
            <div class="logo">🌱 Agrisens 360</div>
            <h1>'.$title.'</h1>
            <div class="meta">Généré le '.$date.'</div>
        </div>
        <div class="content">'.$body.'</div>
        <div class="footer">Agrisens 360 — Gestion intelligente de la ferme © '.date('Y').'</div>
        </body></html>';
    }

    /**
     * Génère le PDF via mPDF et retourne le contenu binaire.
     * @throws \RuntimeException si mPDF n'est pas installé.
     */
    private function render(string $html, string $filename): string
    {
        if (!class_exists(\Mpdf\Mpdf::class)) {
            throw new \RuntimeException(
                'mPDF n\'est pas installé. Exécutez : composer require mpdf/mpdf'
            );
        }

        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'orientation'   => 'L', // Landscape pour les tableaux larges
            'margin_top'    => 5,
            'margin_bottom' => 10,
            'margin_left'   => 8,
            'margin_right'  => 8,
        ]);

        $mpdf->SetTitle($filename);
        $mpdf->SetAuthor('Agrisens 360');
        $mpdf->WriteHTML($html);

        return $mpdf->Output('', 'S'); // 'S' = retourne le contenu (pas download direct)
    }
}
