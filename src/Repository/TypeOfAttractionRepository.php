<?php

namespace App\Repository;

use App\Entity\TypeOfAttraction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
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


    /**
     * @return TypeOfAttraction[]
     */
    public function findGlobalTypes()
    {
        $qb=$this->createQueryBuilder('p');
        return $qb->where($qb->expr()->isNull("p.parentType"))
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $parentId
     * @return TypeOfAttraction[]
     */
    public function findSubTypesFromParentId($parentId)
    {
        $qb=$this->createQueryBuilder('p');
        return $qb->where('p.parentType = :val')
            ->setParameter('val',$parentId)
            ->getQuery()
            ->getResult();
    }

    public function findOneByTypeName($typeName): ?TypeOfAttraction
    {
        try {
            return $this->createQueryBuilder('p')
                ->andWhere('p.type = :val')
                ->setParameter('val', $typeName)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

    public function findMyGlobalType(TypeOfAttraction $typeOfAttraction)
    {
        return $this->findOneBy(array('id'=>$typeOfAttraction->getParentType()->getId()),null);
    }

}
