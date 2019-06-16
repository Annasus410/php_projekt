<?php

namespace App\Repository;

use App\Entity\Announcement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;




/**
 * Class Announcementrepository.
 *
 * @method Announcement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Announcement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Announcement[]    findAll()
 * @method Announcement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnouncementRepository extends ServiceEntityRepository
{
    /**
     * AnnouncementRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Announcement::class);
    }

    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('a.Accepted', 'ASC')->orderBy('a.CreatedAt', 'DESC');
    }

    /**
     * Get or create new query builder.
     *
     * @param \Doctrine\ORM\QueryBuilder|null $queryBuilder Query builder
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?: $this->createQueryBuilder('a');
    }



    /**
     * Save record.
     *
     * @param \App\Entity\Announcement $announcement Announcement Entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Announcement $announcement): void
    {
        $this->_em->persist($announcement);
        $this->_em->flush($announcement);
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Announcement  $announcement Announcement entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Announcement $announcement): void
    {
        $this->_em->remove($announcement);
        $this->_em->flush($announcement);
    }


    /**
     * @param $id
     * @return mixed
     */
    public function findByUserId($id)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.User = :val')
            ->setParameter('val', $id)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function findAccepted()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.Accepted = 1')
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

}



