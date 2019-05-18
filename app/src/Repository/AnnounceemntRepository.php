<?php

namespace App\Repository;

use App\Entity\Announceemnt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Announceemnt|null find($id, $lockMode = null, $lockVersion = null)
 * @method Announceemnt|null findOneBy(array $criteria, array $orderBy = null)
 * @method Announceemnt[]    findAll()
 * @method Announceemnt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnounceemntRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Announceemnt::class);
    }

    // /**
    //  * @return Announceemnt[] Returns an array of Announceemnt objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Announceemnt
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
