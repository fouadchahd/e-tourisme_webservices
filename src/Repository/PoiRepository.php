<?php

namespace App\Repository;

use App\Entity\Photo;
use App\Entity\Poi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Poi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Poi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Poi[]    findAll()
 * @method Poi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PoiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Poi::class);
    }

    /**
     * @param $poiId
     * @return Photo[]
     */
    public function getAllPoiImages($poiId){
        #/poi/66/images
        $poi=$this->find($poiId);
        return $poi->getPhoto();
    }
    public function getPoiByCity($CityId){
        /*$this->createQueryBuilder('p')
             ->join('p.address','a',null)
             ->join('a.city','c',null)
             ->where('c.id = :cityId')
             ->setParameter('cityId',$CityId)
             ->getQuery()
             ->getResult();*/
        $this->_em
            ->createQuery(
            'SELECT p
             FROM App\Entity\Poi p
             JOIN p.address a
             JOIN a.city c
             WHERE c.Id= :cityId
            ')->setParameter('cityId',$CityId)
              ->getResult();
    }

    public function getPoiCountByCity($CityId)
    {#/poi/count?city=22
        try {
            return $this->createQueryBuilder('p')
                ->select('p.id')
                ->join('p.address', 'a', null)
                ->join('a.city', 'c', null)
                ->where('c.id = :cityId')
                ->setParameter('cityId', $CityId)
                ->getQuery()
                ->getSingleScalarResult();

        } catch (NoResultException $e) {
            return 0;
        } catch (NonUniqueResultException $e) {
            return 0;
        }
    }

    /**
     * @param $parent
     * @return Poi[]
     */
    public function findPoiChildren($parent)
    {#/poi/44/children
        return $this->createQueryBuilder('p')
            ->andWhere('p.parent = :val')
            ->setParameter('val', $parent)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneByName($name): ?Poi
    {#/poi?name="mesium"
        try {
            return $this->createQueryBuilder('p')
                ->andWhere('p.name = :val')
                ->setParameter('val', trim($name))
                ->getQuery()
                ->getOneOrNullResult();
        } catch (\Exception $e) {
            print($e->getMessage());
            return null;
        };
    }

}
