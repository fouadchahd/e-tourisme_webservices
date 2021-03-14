<?php

namespace App\Repository;

use App\Entity\TypeOfAttraction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeOfAttraction|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeOfAttraction|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeOfAttraction[]    findAll()
 * @method TypeOfAttraction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeOfAttractionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeOfAttraction::class);
    }

    // /**
    //  * @return TypeOfAttraction[] Returns an array of TypeOfAttraction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeOfAttraction
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
