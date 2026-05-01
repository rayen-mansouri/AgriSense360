<?php
// src/Service/StockManager.php

namespace App\Service;

use App\Entity\Stock;

class StockManager
{
    /**
     * Règle 1: La quantité ne peut pas être négative
     * Règle 2: Le seuil d'alerte ne peut pas dépasser la quantité
     * 
     * @throws \InvalidArgumentException
     */
    public function validate(Stock $stock): bool
    {
        // Règle 1: La quantité ne peut pas être négative
        if ($stock->getQuantiteActuelle() < 0) {
            throw new \InvalidArgumentException('La quantité ne peut pas être négative');
        }

        $seuil = $stock->getSeuilAlerte();
        $quantite = $stock->getQuantiteActuelle();
        
        if ($seuil !== null && $seuil > $quantite) {
            throw new \InvalidArgumentException('Le seuil d\'alerte ne peut pas dépasser la quantité disponible');
        }

        return true;
    }

    public function isEnAlerte(Stock $stock): bool
    {
        $quantite = $stock->getQuantiteActuelle();
        $seuil = $stock->getSeuilAlerte();
        
        if ($seuil === null || $seuil <= 0) {
            return false;
        }
        
        return $quantite <= $seuil;
    }
}