<?php

namespace App\Repository;

use App\Entity\Affectation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Affectation>
 */
class AffectationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Affectation::class);
    }

    public function ListAll(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.debut', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function affectationRestaurant($restaurant): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.restaurant = :restaurant')
            ->setParameter('restaurant', $restaurant)
            ->orderBy('a.debut','DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function filtreRestaurantPoste($restaurant,$poste):array
    {
        return $this->createQueryBuilder('a')
            ->where('a.restaurant = :restaurant')
            ->andWhere('a.fonction = :poste')
            ->setParameter('restaurant', $restaurant)
            ->setParameter('poste', $poste)
            ->getQuery()
            ->getResult()
            ;
    }

    public function filtreRestaurantDebut($restaurant,$debut):array
    {
        return $this->createQueryBuilder('a')
            ->where('a.restaurant = :restaurant')
            ->andWhere('a.debut = :debut')
            ->setParameter('restaurant', $restaurant)
            ->setParameter('debut', $debut)
            ->getQuery()
            ->getResult()
            ;
    }

    public function affectationCollaborateur($collaborateur):array
    {
        return $this->createQueryBuilder('a')
            ->where('a.collaborateur = :collaborateur')
            ->setParameter('collaborateur', $collaborateur)
            ->getQuery()
            ->getResult()
            ;
    }

    public function dateCollaborateur($collaborateur):array
    {
        return $this->createQueryBuilder('a')
            ->select('DISTINCT a.debut')
            ->andWhere('a.collaborateur = :collaborateur')
            ->setParameter('collaborateur', $collaborateur)
            ->orderBy('a.debut', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function filtreCollaborateurPoste($collaborateur, $poste):array
    {
        return $this->createQueryBuilder('a')
            ->where('a.collaborateur = :collaborateur')
            ->andWhere('a.fonction = :poste')
            ->setParameter('collaborateur', $collaborateur)
            ->setParameter('poste', $poste)
            ->getQuery()
            ->getResult()
            ;
    }

    public function filtreCollaborateurDebut($collaborateur, $debut):array
    {
        return $this->createQueryBuilder('a')
        ->where('a.collaborateur = :collaborateur')
        ->andWhere('a.debut = :debut')
        ->setParameter('collaborateur', $collaborateur)
        ->setParameter('debut', $debut)
        ->getQuery()
        ->getResult()
        ;
    }

    public function filtrePoste($poste): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.fonction = :poste')
            ->setParameter('poste', $poste)
            ->getQuery()
            ->getResult()
            ;
    }

    public function filtreDateDebut($debut): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.debut = :debut')
            ->setParameter('debut', $debut)
            ->getQuery()
            ->getResult()
            ;
    }

    public function filtreDateFin($fin): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.fin = :fin')
            ->setParameter('fin', $fin)
            ->getQuery()
            ->getResult()
            ;
    }

    public function listDate():array
    {
        return $this->createQueryBuilder('a')
        ->select('DISTINCT a.debut')
        ->andWhere('a.fin IS NULL')
        ->orderBy('a.debut', 'DESC')
        ->getQuery()
        ->getResult()
        ;

    }

    public function listDebut():array
    {
        return $this->createQueryBuilder('a')
        ->select('DISTINCT a.debut')
        ->orderBy('a.debut', 'DESC')
        ->getQuery()
        ->getResult()
        ;

    }
    
    public function listFin():array
    {
        return $this->createQueryBuilder('a')
        ->select('DISTINCT a.fin')
        ->andWhere('a.fin IS NOT NULL')
        ->orderBy('a.fin', 'DESC')
        ->getQuery()
        ->getResult()
        ;

    }
}
