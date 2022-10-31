<?php

namespace App\Repository;

use App\Entity\CategorieP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategorieP|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieP|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieP[]    findAll()
 * @method CategorieP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriePRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieP::class);
    }

    // /**
    //  * @return CategorieP[] Returns an array of CategorieP objects
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
    public function findOneBySomeField($value): ?CategorieP
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getTotalCat()
    {
        $query=$this->createQueryBuilder('c')
            ->select('COUNT(c)');
        return $query->getQuery()
            ->getSingleScalarResult();
    }
    public function getPaginateCat($page,$limit){
        $query=$this->createQueryBuilder('c')
            ->setFirstResult(($page*$limit)-$limit)
            ->setMaxResults($limit);
        return $query->getQuery()
            ->getResult();

    }
}
