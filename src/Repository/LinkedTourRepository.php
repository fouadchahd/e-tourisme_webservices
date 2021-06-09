<?php

namespace App\Repository;

use App\Entity\LinkedTour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LinkedTour|null find($id, $lockMode = null, $lockVersion = null)
 * @method LinkedTour|null findOneBy(array $criteria, array $orderBy = null)
 * @method LinkedTour[]    findAll()
 * @method LinkedTour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinkedTourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LinkedTour::class);
    }

    // /**
    //  * @return LinkedTour[] Returns an array of LinkedTour objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LinkedTour
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
