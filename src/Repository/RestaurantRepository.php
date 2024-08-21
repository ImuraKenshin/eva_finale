<?php

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Restaurant>
 */
class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }

    public function listAll(): array
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.ville', 'ASC')
            ->orderBy('r.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function listVille():array
    {
        return $this->createQueryBuilder('r')
        ->select('DISTINCT r.ville')
        ->orderBy('r.ville', 'ASC')
        ->getQuery()
        ->getResult()
        ;

    }

    public function FilterByVille($ville): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.ville = :ville')
            ->setParameter('ville', $ville)
            ->getQuery()
            ->getResult()
            ;
    }

    public function FilterByEtat($etat): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.etat = :etat')
            ->setParameter('etat', $etat)
            ->getQuery()
            ->getResult()
            ;
    }

    public function searchRestaurant($search): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.nom like :search')
            ->orWhere('r.ville like :search')
            ->orWhere('r.codePostal like :search')
            ->setParameter('search', "%".$search."%")
            ->getQuery()
            ->getResult()
            ;
    }

    public function detailRestaurant($id)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
