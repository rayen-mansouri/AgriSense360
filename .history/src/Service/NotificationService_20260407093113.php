<?php
namespace App\Service;

use App\Repository\StockRepository;

class NotificationService
{
    public function __construct(private StockRepository $stockRepo) {}

    public function getStockNotifications(): array
    {
        $notifications = [];

        foreach ($this->stockRepo->findRuptures() as $s) {
            $notifications[] = ['id' => 'rupture-'.$s->getId(), 'level' => 'critical', 'type' => 'danger',
                'icon' => 'fa-circle-xmark', 'title' => '🔴 Rupture de stock',
                'desc' => $s->getProduit()->getNom().' — Stock épuisé',
                'url' => '/stock/'.$s->getId().'/edit', 'time' => 'Maintenant', 'read' => false];
        }

        foreach ($this->stockRepo->findAlertes() as $s) {
            if ((float)$s->getQuantiteActuelle() > 0) {
                $pct = $s->getSeuilAlerte() > 0 ? round((float)$s->getQuantiteActuelle() / (float)$s->getSeuilAlerte() * 100) : 0;
                $notifications[] = ['id' => 'alerte-'.$s->getId(), 'level' => 'warning', 'type' => 'warning',
                    'icon' => 'fa-triangle-exclamation', 'title' => '⚠️ Stock bas',
                    'desc' => $s->getProduit()->getNom().' — '.$s->getQuantiteActuelle().' '.$s->getUniteMesure().' ('.$pct.'% du seuil)',
                    'url' => '//'.$s->getId().'/modifier', 'time' => 'Stock insuffisant', 'read' => false];
            }
        }

        foreach ($this->stockRepo->findExpiringSoon(30) as $s) {
            $days = (new \DateTime())->diff($s->getDateExpiration())->days;
            $notifications[] = ['id' => 'expiry-'.$s->getId(), 'level' => $days <= 7 ? 'critical' : 'warning',
                'type' => $days <= 7 ? 'danger' : 'warning', 'icon' => 'fa-calendar-xmark',
                'title' => '📅 Expiration proche',
                'desc' => $s->getProduit()->getNom().' — Expire dans '.$days.' jour(s)',
                'url' => '/stock/'.$s->getId().'/modifier',
                'time' => 'Expire le '.$s->getDateExpiration()->format('d/m/Y'), 'read' => false];
        }

        usort($notifications, fn($a, $b) => ['critical'=>0,'warning'=>1,'info'=>2][$a['level']] <=> ['critical'=>0,'warning'=>1,'info'=>2][$b['level']]);
        return $notifications;
    }

    public function countUnread(): int { return count($this->getStockNotifications()); }

    public function getSummary(): array
    {
        return [
            'total'    => count($this->stockRepo->findAlertes()) + count($this->stockRepo->findExpiringSoon(30)),
            'critical' => count($this->stockRepo->findRuptures()),
            'warning'  => count($this->stockRepo->findAlertes()) - count($this->stockRepo->findRuptures()),
            'expiring' => count($this->stockRepo->findExpiringSoon(30)),
        ];
    }
}
