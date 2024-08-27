<?php

namespace App\Repository;

use App\Entity\Collaborateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Collaborateur>
 */
class CollaborateurRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Collaborateur::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Collaborateur) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    //    /**
    //     * @return Collaborateur[] Returns an array of Collaborateur objects
    //     */
        public function listAll(): array
        {
            return $this->createQueryBuilder('c')
                ->orderBy('c.nom', 'ASC')
                ->orderBy('c.prenom','ASC')
                ->getQuery()
                ->getResult()
            ;
        }

        public function listAllActif(): array
        {
            return $this->createQueryBuilder('c')
                ->Where('c.etat = 1')
                ->orderBy('c.nom', 'ASC')
                ->orderBy('c.prenom','ASC')
                ->getQuery()
                ->getResult()
            ;
        }

        public function searchCollaborateur($search): array
        {
            return $this->createQueryBuilder('c')
                ->Where('c.nom like :search')
                ->orWhere('c.prenom like :search')
                ->orWhere('c.mail like :search')
                ->setParameter('search', "%".$search."%")
                ->getQuery()
                ->getResult()
                ;
        }

        public function detailCollaborateur($id){
            return $this->createQueryBuilder('c')
                ->andwhere('c.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getOneOrNullResult()
                ;
        }
        
}
