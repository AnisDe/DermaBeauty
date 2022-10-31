<?php

namespace App\Repository;

use App\Entity\ConsLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConsLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConsLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConsLike[]    findAll()
 * @method ConsLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConsLike::class);
    }

    // /**
    //  * @return ConsLike[] Returns an array of ConsLike objects
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
    public function findOneBySomeField($value): ?ConsLike
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
