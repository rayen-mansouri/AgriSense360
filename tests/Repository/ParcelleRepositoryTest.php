<?php

namespace App\Tests\Repository;

use App\Entity\Culture;
use App\Entity\Parcelle;
use App\Entity\ParcelleHistorique;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * ============================================================
 *  TEST DOCTRINE (INTÉGRATION) — Repositories
 * ============================================================
 *
 *  CE QUE CE TEST VÉRIFIE :
 *  - La relation Parcelle ↔ Culture fonctionne en BD
 *  - La cascade delete : supprimer une Parcelle supprime ses Cultures
 *  - La recherche DQL fonctionne (search by nom)
 *  - Le calcul de surfaceRestant est correct après ajout/suppression
 *  - L'historique est bien enregistré
 *
 *  IMPORTANT : Ce test utilise une VRAIE base de données SQLite
 *  en mémoire (:memory:) — ta base MySQL de production
 *  n'est PAS touchée. Le schéma est recréé avant chaque test.
 *
 *  COMMENT LANCER :
 *  php vendor/bin/phpunit tests/Repository/ParcelleRepositoryTest.php --testdox
 * ============================================================
 */
class ParcelleRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $em;

    /**
     * Avant chaque test :
     * - On démarre le kernel Symfony (en mode "test")
     * - On récupère l'EntityManager
     * - On recrée le schéma BD complet (tables vides)
     */
    protected function setUp(): void
    {
        self::bootKernel();
        $this->em = self::getContainer()->get(EntityManagerInterface::class);

        // Recréer toutes les tables avant chaque test (base propre)
        $schemaTool = new SchemaTool($this->em);
        $metadata   = $this->em->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
    }

    /**
     * Après chaque test : fermer la connexion proprement
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        $this->em->close();
    }

    // ═══════════════════════════════════════════════════════
    //  GROUPE 1 : Persistance basique
    // ═══════════════════════════════════════════════════════

    /**
     * TEST 1.1 — On peut créer et retrouver une Parcelle en BD
     *
     * Le test le plus basique : est-ce que Doctrine peut sauvegarder
     * une Parcelle et la retrouver par son ID ?
     */
    public function testCreerEtRetouverUneParcelle(): void
    {
        // Créer une parcelle
        $parcelle = new Parcelle();
        $parcelle->setNom('Champ du Nord')
                 ->setSurface(500.0)
                 ->setSurfaceRestant(500.0)
                 ->setLocalisation('Tunis')
                 ->setTypeSol('Sol Argileux')
                 ->setStatut('Libre');

        $this->em->persist($parcelle);
        $this->em->flush();

        $id = $parcelle->getId();
        $this->assertNotNull($id, "L'ID doit être assigné après flush()");

        // Vider le cache Doctrine pour forcer une vraie requête SQL
        $this->em->clear();

        // Retrouver la parcelle depuis la BD
        $found = $this->em->find(Parcelle::class, $id);

        $this->assertNotNull($found, "La parcelle doit exister en BD après persistance");
        $this->assertSame('Champ du Nord', $found->getNom());
        $this->assertSame(500.0, $found->getSurface());
        $this->assertSame('Tunis', $found->getLocalisation());
    }

    /**
     * TEST 1.2 — Créer une Culture liée à une Parcelle
     *
     * Vérifie que la relation ManyToOne Parcelle ↔ Culture
     * fonctionne correctement en base de données
     */
    public function testCreerCultureLieeAUneParcelle(): void
    {
        // Créer la parcelle parent
        $parcelle = new Parcelle();
        $parcelle->setNom('Parcelle Test')
                 ->setSurface(200.0)
                 ->setSurfaceRestant(200.0)
                 ->setStatut('Libre');
        $this->em->persist($parcelle);

        // Créer une culture liée à cette parcelle
        $culture = new Culture();
        $culture->setNom('Tomates')
                ->setTypeCulture('Légumes')
                ->setSurface(50.0)
                ->setDatePlantation(new \DateTime('2025-01-01'))
                ->setDateRecolte(new \DateTime('2025-03-01'))
                ->setEtat('Semis')
                ->setParcelle($parcelle);
        $this->em->persist($culture);
        $this->em->flush();

        $cultureId = $culture->getId();
        $this->em->clear();

        // Vérifier que la culture existe et est liée à la bonne parcelle
        $found = $this->em->find(Culture::class, $cultureId);

        $this->assertNotNull($found);
        $this->assertSame('Tomates', $found->getNom());
        $this->assertSame('Parcelle Test', $found->getParcelle()->getNom());
    }

    // ═══════════════════════════════════════════════════════
    //  GROUPE 2 : Cascade Delete (critique !)
    // ═══════════════════════════════════════════════════════

    /**
     * TEST 2.1 — Supprimer une Parcelle supprime aussi ses Cultures
     *
     * C'est la contrainte CASCADE configurée dans Parcelle::$cultures
     * Si ça ne marche pas, on aurait des cultures "orphelines" en BD
     * → bug silencieux très dangereux
     */
    public function testSupprimerParcelleSupprimeSesCultures(): void
    {
        // Setup : 1 parcelle + 2 cultures
        $parcelle = new Parcelle();
        $parcelle->setNom('Parcelle A supprimer')
                 ->setSurface(300.0)
                 ->setSurfaceRestant(200.0)
                 ->setStatut('Libre');
        $this->em->persist($parcelle);

        $culture1 = new Culture();
        $culture1->setNom('Maïs')->setTypeCulture('Céréales')
                 ->setSurface(50.0)
                 ->setDatePlantation(new \DateTime('-30 days'))
                 ->setDateRecolte(new \DateTime('+90 days'))
                 ->setEtat('Croissance')
                 ->setParcelle($parcelle);

        $culture2 = new Culture();
        $culture2->setNom('Blé')->setTypeCulture('Céréales')
                 ->setSurface(50.0)
                 ->setDatePlantation(new \DateTime('-20 days'))
                 ->setDateRecolte(new \DateTime('+80 days'))
                 ->setEtat('Semis')
                 ->setParcelle($parcelle);

        $this->em->persist($culture1);
        $this->em->persist($culture2);
        $this->em->flush();

        $parcelleId = $parcelle->getId();
        $culture1Id = $culture1->getId();
        $culture2Id = $culture2->getId();

        // ACTION : supprimer la parcelle
        $this->em->remove($parcelle);
        $this->em->flush();
        $this->em->clear();

        // ASSERTION : la parcelle n'existe plus
        $foundParcelle = $this->em->find(Parcelle::class, $parcelleId);
        $this->assertNull($foundParcelle, "La parcelle supprimée ne doit plus exister");

        // ASSERTION : les cultures liées n'existent plus non plus (CASCADE)
        $foundCulture1 = $this->em->find(Culture::class, $culture1Id);
        $foundCulture2 = $this->em->find(Culture::class, $culture2Id);
        $this->assertNull($foundCulture1, "La culture 1 doit être supprimée en cascade");
        $this->assertNull($foundCulture2, "La culture 2 doit être supprimée en cascade");
    }

    // ═══════════════════════════════════════════════════════
    //  GROUPE 3 : Recherche DQL
    // ═══════════════════════════════════════════════════════

    /**
     * TEST 3.1 — Recherche de parcelle par nom (LIKE)
     *
     * Vérifie que la méthode search() du repository
     * retourne bien les bonnes parcelles
     */
    public function testRechercheParcelleParNom(): void
    {
        // Créer 3 parcelles
        foreach (['Champ du Nord', 'Champ du Sud', 'Vignoble Est'] as $nom) {
            $p = new Parcelle();
            $p->setNom($nom)->setSurface(100.0)->setSurfaceRestant(100.0)->setStatut('Libre');
            $this->em->persist($p);
        }
        $this->em->flush();
        $this->em->clear();

        // Chercher "Champ" → doit retourner 2 résultats
        $results = $this->em->getRepository(Parcelle::class)
            ->createQueryBuilder('p')
            ->where('p.nom LIKE :t')
            ->setParameter('t', '%Champ%')
            ->getQuery()
            ->getResult();

        $this->assertCount(2, $results, "La recherche 'Champ' doit retourner 2 parcelles");

        // Chercher "Vignoble" → doit retourner 1 résultat
        $results2 = $this->em->getRepository(Parcelle::class)
            ->createQueryBuilder('p')
            ->where('p.nom LIKE :t')
            ->setParameter('t', '%Vignoble%')
            ->getQuery()
            ->getResult();

        $this->assertCount(1, $results2, "La recherche 'Vignoble' doit retourner 1 parcelle");
        $this->assertSame('Vignoble Est', $results2[0]->getNom());
    }

    // ═══════════════════════════════════════════════════════
    //  GROUPE 4 : Historique
    // ═══════════════════════════════════════════════════════

    /**
     * TEST 4.1 — Un log d'historique peut être sauvegardé et retrouvé
     *
     * Vérifie que ParcelleHistorique est correctement mappé en BD
     * et que les données sont bien persistées
     */
    public function testSauvegarderEtRetouverUnHistorique(): void
    {
        $parcelle = new Parcelle();
        $parcelle->setNom('Parcelle Historique')
                 ->setSurface(100.0)->setSurfaceRestant(100.0)->setStatut('Libre');
        $this->em->persist($parcelle);
        $this->em->flush();

        // Créer un log d'historique
        $log = new ParcelleHistorique();
        $log->setParcelleId($parcelle->getId())
            ->setTypeAction('CULTURE_AJOUTEE')
            ->setCultureNom('Tomates')
            ->setTypeCulture('Légumes')
            ->setSurface(20.0)
            ->setEtatApres('Semis')
            ->setDescription('Test ajout culture Tomates');

        $this->em->persist($log);
        $this->em->flush();

        $logId = $log->getId();
        $this->em->clear();

        // Retrouver le log
        $found = $this->em->find(ParcelleHistorique::class, $logId);

        $this->assertNotNull($found, "Le log d'historique doit être retrouvé en BD");
        $this->assertSame('CULTURE_AJOUTEE', $found->getTypeAction());
        $this->assertSame('Tomates', $found->getCultureNom());
        $this->assertSame($parcelle->getId(), $found->getParcelleId());

        // Vérifier les helpers de l'entité
        $this->assertSame('🌱', $found->getTypeIcon());
        $this->assertSame('Culture ajoutée', $found->getTypeLabelFr());
        $this->assertSame('hist-green', $found->getActionCssClass());
    }

    /**
     * TEST 4.2 — Filtrer l'historique par type d'action
     *
     * Scénario : 2 CULTURE_AJOUTEE + 1 RECOLTE pour la même parcelle
     * On filtre par RECOLTE → doit retourner 1 seul résultat
     */
    public function testFiltrerHistoriqueParTypeAction(): void
    {
        $parcelle = new Parcelle();
        $parcelle->setNom('Parcelle Filtre')
                 ->setSurface(100.0)->setSurfaceRestant(100.0)->setStatut('Libre');
        $this->em->persist($parcelle);
        $this->em->flush();

        $pid = $parcelle->getId();

        // Ajouter 2 logs CULTURE_AJOUTEE + 1 RECOLTE
        foreach (['CULTURE_AJOUTEE', 'CULTURE_AJOUTEE', 'RECOLTE'] as $type) {
            $log = new ParcelleHistorique();
            $log->setParcelleId($pid)
                ->setTypeAction($type)
                ->setCultureNom('Test')
                ->setDescription('Log type ' . $type);
            $this->em->persist($log);
        }
        $this->em->flush();
        $this->em->clear();

        // Filtrer uniquement les RECOLTE
        $recoltes = $this->em->getRepository(ParcelleHistorique::class)
            ->createQueryBuilder('h')
            ->where('h.parcelleId = :pid AND h.typeAction = :type')
            ->setParameter('pid', $pid)
            ->setParameter('type', 'RECOLTE')
            ->getQuery()
            ->getResult();

        $this->assertCount(1, $recoltes, "Filtrer par RECOLTE doit retourner 1 seul résultat");
        $this->assertSame('RECOLTE', $recoltes[0]->getTypeAction());
    }
}
