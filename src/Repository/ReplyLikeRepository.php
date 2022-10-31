<?php

namespace App\Repository;

use App\Entity\ReplyLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReplyLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReplyLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReplyLike[]    findAll()
 * @method ReplyLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReplyLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReplyLike::class);
    }

    // /**
    //  * @return ReplyLike[] Returns an array of ReplyLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReplyLike
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
