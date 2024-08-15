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
            ->andWhere('a.fin = ""')
            ->setParameter('restaurant', $restaurant)
            ->orderBy('a.debut','DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function historiqueRestaurant($restaurant): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.restaurant = :restaurant')
            ->setParameter('restaurant', $restaurant)
            ->orderBy('a.debut','DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function filtrePoste($poste): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.poste = :poste')
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
}
