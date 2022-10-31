<?php

namespace App\Repository;

use App\Entity\CategorieDerm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategorieDerm|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieDerm|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieDerm[]    findAll()
 * @method CategorieDerm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieDermRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieDerm::class);
    }

    // /**
    //  * @return CategorieDerm[] Returns an array of CategorieDerm objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategorieDerm
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getPaginateCat($page,$limit){
       $query=$this->createQueryBuilder('c')
            ->orderBy('c.ref')
            ->setFirstResult(($page*$limit)-$limit)
            ->setMaxResults($limit);
        return $query->getQuery()
            ->getResult();

    }
    public function getTotalCat()
    {
        $query=$this->createQueryBuilder('c')
            ->select('COUNT(c)');
        return $query->getQuery()
            ->getSingleScalarResult();
    }


}
