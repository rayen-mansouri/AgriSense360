<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

// ============================================================
// ERREURS CORRIGÉES :
//
// 1. Repository vide généré par le reverse engineering → méthodes
//    findFiltered(), findAllCategories(), findByCategorie(),
//    searchByNom() ajoutées (requises par GestionController)
// ============================================================

class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    /**
     * Recherche + tri multi-critères.
     * Utilisé par le dashboard et les exports PDF.
     *
     * @param string $search   Terme de recherche (nom, catégorie, description)
     * @param string $categorie Filtre par catégorie exacte
     * @param string $sort     Champ de tri : 'nom' | 'categorie' | 'prix_unitaire' | 'created_at'
     * @param string $dir      Direction : 'asc' | 'desc'
     */
    public function findFiltered(
        string $search   = '',
        string $categorie = '',
        string $sort     = 'nom',
        string $dir      = 'asc'
    ): array {
        $allowed = ['nom', 'categorie', 'prix_unitaire', 'created_at'];
        $sort    = in_array($sort, $allowed) ? $sort : 'nom';
        $dir     = strtolower($dir) === 'desc' ? 'DESC' : 'ASC';

        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.stocks', 's')
            ->addSelect('s');

        if ($search !== '') {
            $qb->andWhere('p.nom LIKE :q OR p.categorie LIKE :q OR p.description LIKE :q')
               ->setParameter('q', '%'.$search.'%');
        }

        if ($categorie !== '') {
            $qb->andWhere('p.categorie = :cat')
               ->setParameter('cat', $categorie);
        }

        $qb->orderBy('p.'.$sort, $dir);

        return $qb->getQuery()->getResult();
    }

    /**
     * Retourne la liste unique de toutes les catégories présentes en BDD.
     * Utilisé pour les filtres de la barre de navigation.
     */
    public function findAllCategories(): array
    {
        $results = $this->createQueryBuilder('p')
            ->select('DISTINCT p.categorie')
            ->where('p.categorie IS NOT NULL')
            ->orderBy('p.categorie', 'ASC')
            ->getQuery()
            ->getScalarResult();

        return array_column($results, 'categorie');
    }

    /**
     * Recherche par nom/catégorie/description.
     * Alias de findFiltered() pour la compatibilité avec les anciens appels.
     */
    public function searchByNom(string $query): array
    {
        return $this->findFiltered($query);
    }

    /**
     * Filtre par catégorie exacte.
     */
    public function findByCategorie(string $categorie): array
    {
        return $this->findFiltered('', $categorie);
    }
}
