<?php

namespace App\Tests\Service;

use App\Entity\Culture;
use App\Entity\Parcelle;
use App\Service\CultureService;
use App\Service\MailService;
use App\Service\ParcelleHistoriqueService;
use App\Service\ParcelleService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

/**
 * ============================================================
 *  TEST UNITAIRE — CultureService
 * ============================================================
 *
 *  CE QUE CE TEST VÉRIFIE :
 *  - Le calcul d'état d'une culture (Semis, Croissance, Maturité,
 *    Récolte Prévue, Récolte en Retard) selon les dates
 *  - La validation de surface lors de la création d'une culture
 *  - Le calcul de la date de récolte automatique
 *  - Les helpers de l'entité Culture (isReadyToHarvest, getDaysLate)
 *
 *  POURQUOI CES TESTS :
 *  Ces fonctions contiennent la logique métier CRITIQUE de l'application.
 *  Si calculateEtat() est cassé, toutes les cultures affichent
 *  un mauvais état. Les tests garantissent que ça reste correct.
 *
 *  COMMENT LANCER :
 *  php vendor/bin/phpunit tests/Service/CultureServiceTest.php --testdox
 * ============================================================
 */
class CultureServiceTest extends TestCase
{
    // ═══════════════════════════════════════════════════════
    //  GROUPE 1 : calculateEtat() — le cœur de l'application
    // ═══════════════════════════════════════════════════════

    /**
     * TEST 1.1 — Une culture plantée aujourd'hui est en état "Semis"
     *
     * Logique : si on est dans les premiers jours depuis la plantation,
     * la culture vient juste de commencer → état = Semis
     */
    public function testEtatSemisQuandCultureVientDEtreCommencee(): void
    {
        $dp = new \DateTime('today');           // plantée aujourd'hui
        $dr = new \DateTime('+120 days');       // récolte dans 120 jours

        $etat = CultureService::calculateEtat($dp, $dr, 'Maïs');

        $this->assertSame(
            'Semis',
            $etat,
            "Une culture plantée aujourd'hui avec récolte lointaine doit être en 'Semis'"
        );
    }

    /**
     * TEST 1.2 — Une culture plantée il y a longtemps est en "Croissance"
     *
     * Maïs : phases [30, 60, 30] → croissance commence à 30 jours
     * Ici on est à 45 jours → dans la phase croissance
     */
    public function testEtatCroissanceApresPhaseSeeds(): void
    {
        $dp = new \DateTime('-45 days');        // plantée il y a 45 jours
        $dr = new \DateTime('+75 days');        // récolte dans 75 jours

        $etat = CultureService::calculateEtat($dp, $dr, 'Maïs');

        $this->assertSame(
            'Croissance',
            $etat,
            "Une culture à 45 jours (Maïs phase croissance = 30-90j) doit être en 'Croissance'"
        );
    }

    /**
     * TEST 1.3 — Une culture proche de la récolte (dans 5 jours) = "Récolte Prévue"
     *
     * Logique : si daysUntilHarvest <= 7 → "Récolte Prévue"
     * C'est la fenêtre d'alerte pour prévenir l'agriculteur
     */
    public function testEtatRecoltePrevueQuandDans5Jours(): void
    {
        $dp = new \DateTime('-100 days');       // plantée il y a longtemps
        $dr = new \DateTime('+5 days');         // récolte DANS 5 JOURS

        $etat = CultureService::calculateEtat($dp, $dr, 'Maïs');

        $this->assertSame(
            'Récolte Prévue',
            $etat,
            "Une culture dont la récolte est dans 5 jours doit être en 'Récolte Prévue'"
        );
    }

    /**
     * TEST 1.4 — Une culture dont la date de récolte est dépassée = "Récolte en Retard"
     *
     * Logique : si daysUntilHarvest < 0 → "Récolte en Retard"
     * C'est le cas critique → l'appli doit envoyer un email d'alerte
     */
    public function testEtatRecolteEnRetardQuandDateDepassee(): void
    {
        $dp = new \DateTime('-150 days');       // plantée il y a 150 jours
        $dr = new \DateTime('-10 days');        // date de récolte DÉPASSÉE

        $etat = CultureService::calculateEtat($dp, $dr, 'Maïs');

        $this->assertSame(
            'Récolte en Retard',
            $etat,
            "Une culture dont la date de récolte est passée doit être 'Récolte en Retard'"
        );
    }

    /**
     * TEST 1.5 — La récolte est exactement aujourd'hui → "Récolte Prévue"
     *
     * Cas limite (edge case) : daysUntilHarvest = 0 → dans les 7 jours → Récolte Prévue
     */
    public function testEtatRecoltePrevueQuandAujourdhuiMeme(): void
    {
        $dp = new \DateTime('-120 days');
        $dr = new \DateTime('today');           // récolte AUJOURD'HUI

        $etat = CultureService::calculateEtat($dp, $dr, 'Maïs');

        $this->assertSame(
            'Récolte Prévue',
            $etat,
            "Une culture dont la récolte est aujourd'hui doit être 'Récolte Prévue'"
        );
    }

    // ═══════════════════════════════════════════════════════
    //  GROUPE 2 : calculateHarvestDate() — calcul automatique
    // ═══════════════════════════════════════════════════════

    /**
     * TEST 2.1 — La date de récolte du Maïs est bien calculée
     *
     * Maïs : 30 + 60 + 30 = 120 jours total
     * Si planté aujourd'hui → récolte dans 120 jours
     */
    public function testCalculateHarvestDateMais(): void
    {
        $dp = new \DateTime('2025-01-01');
        $dr = CultureService::calculateHarvestDate($dp, 'Maïs');

        $expected = new \DateTime('2025-05-01');  // 2025-01-01 + 120 jours

        $this->assertSame(
            $expected->format('Y-m-d'),
            $dr->format('Y-m-d'),
            "La date de récolte du Maïs doit être 120 jours après la plantation"
        );
    }

    /**
     * TEST 2.2 — La date de récolte pour une culture inconnue utilise le défaut
     *
     * Si le nom de la culture n'est pas dans DURATIONS,
     * on utilise [20, 50, 20] = 90 jours par défaut
     */
    public function testCalculateHarvestDateCultureInconnueUtileDefaut(): void
    {
        $dp = new \DateTime('2025-01-01');
        $dr = CultureService::calculateHarvestDate($dp, 'CultureInconnue');

        $expected = new \DateTime('2025-04-01');  // 90 jours

        $this->assertSame(
            $expected->format('Y-m-d'),
            $dr->format('Y-m-d'),
            "Une culture inconnue doit utiliser 90 jours par défaut"
        );
    }

    // ═══════════════════════════════════════════════════════
    //  GROUPE 3 : createCulture() — validation de la surface
    // ═══════════════════════════════════════════════════════

    /**
     * TEST 3.1 — Refus si surface demandée > surface disponible
     *
     * Scénario réel : parcelle avec 10m² restants,
     * l'agriculteur essaie d'ajouter une culture de 50m² → REFUS
     *
     * On MOCK les dépendances (EntityManager, etc.) car on teste
     * uniquement la LOGIQUE de validation, pas la BD
     */
    public function testCreateCultureRefuseQuandSurfaceTropGrande(): void
    {
        // Créer les mocks (fausses dépendances)
        $em              = $this->createMock(EntityManagerInterface::class);
        $parcelleService = $this->createMock(ParcelleService::class);
        $mailService     = $this->createMock(MailService::class);
        $histService     = $this->createMock(ParcelleHistoriqueService::class);

        $service = new CultureService($em, $parcelleService, $mailService, $histService);

        // Parcelle avec seulement 10m² disponibles
        $parcelle = new Parcelle();
        $parcelle->setNom('Test')->setSurface(100.0)->setSurfaceRestant(10.0)->setStatut('Libre');

        // Culture qui demande 50m² → trop grand
        $culture = new Culture();
        $culture->setNom('Maïs')
                ->setTypeCulture('Céréales')
                ->setSurface(50.0)
                ->setDatePlantation(new \DateTime('today'))
                ->setDateRecolte(new \DateTime('+120 days'));

        $result = $service->createCulture($culture, $parcelle);

        // Assertions
        $this->assertFalse(
            $result['ok'],
            "La création doit échouer quand la surface est trop grande"
        );
        $this->assertStringContainsString(
            'Surface trop grande',
            $result['error'],
            "Le message d'erreur doit mentionner 'Surface trop grande'"
        );
    }

    /**
     * TEST 3.2 — Refus si le nom de la culture est vide
     *
     * Validation basique : un champ obligatoire vide → erreur claire
     */
    public function testCreateCultureRefuseQuandNomVide(): void
    {
        $em              = $this->createMock(EntityManagerInterface::class);
        $parcelleService = $this->createMock(ParcelleService::class);
        $mailService     = $this->createMock(MailService::class);
        $histService     = $this->createMock(ParcelleHistoriqueService::class);

        $service = new CultureService($em, $parcelleService, $mailService, $histService);

        $parcelle = new Parcelle();
        $parcelle->setNom('Test')->setSurface(100.0)->setSurfaceRestant(100.0)->setStatut('Libre');

        $culture = new Culture();
        $culture->setNom('')       // NOM VIDE
                ->setTypeCulture('Céréales')
                ->setSurface(10.0)
                ->setDatePlantation(new \DateTime('today'))
                ->setDateRecolte(new \DateTime('+120 days'));

        $result = $service->createCulture($culture, $parcelle);

        $this->assertFalse($result['ok']);
        $this->assertStringContainsString(
            'nom',
            mb_strtolower($result['error']),
            "Le message d'erreur doit mentionner le nom"
        );
    }

    // ═══════════════════════════════════════════════════════
    //  GROUPE 4 : Entité Culture — helpers
    // ═══════════════════════════════════════════════════════

    /**
     * TEST 4.1 — isReadyToHarvest() = true quand récolte dans 5 jours
     */
    public function testIsReadyToHarvestQuandProche(): void
    {
        $culture = new Culture();
        $culture->setDateRecolte(new \DateTime('+5 days'));

        $this->assertTrue(
            $culture->isReadyToHarvest(),
            "isReadyToHarvest doit retourner true quand la récolte est dans 5 jours"
        );
    }

    /**
     * TEST 4.2 — isReadyToHarvest() = false quand récolte dans 60 jours
     */
    public function testIsReadyToHarvestQuandTropLoin(): void
    {
        $culture = new Culture();
        $culture->setDateRecolte(new \DateTime('+60 days'));

        $this->assertFalse(
            $culture->isReadyToHarvest(),
            "isReadyToHarvest doit retourner false quand la récolte est loin"
        );
    }

    /**
     * TEST 4.3 — getDaysLate() retourne le bon nombre de jours de retard
     */
    public function testGetDaysLateRetourneNombreCorrect(): void
    {
        $culture = new Culture();
        $culture->setDateRecolte(new \DateTime('-7 days'));  // en retard de 7 jours

        $this->assertSame(
            7,
            $culture->getDaysLate(),
            "getDaysLate doit retourner 7 quand la récolte était il y a 7 jours"
        );
    }

    /**
     * TEST 4.4 — getDaysLate() retourne 0 si pas encore en retard
     */
    public function testGetDaysLateRetourneZeroSiPasEnRetard(): void
    {
        $culture = new Culture();
        $culture->setDateRecolte(new \DateTime('+10 days'));

        $this->assertSame(
            0,
            $culture->getDaysLate(),
            "getDaysLate doit retourner 0 quand la récolte n'est pas encore passée"
        );
    }
}
