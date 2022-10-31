<?php

namespace App\Repository;

use App\Entity\CategorieCentre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategorieCentre|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieCentre|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieCentre[]    findAll()
 * @method CategorieCentre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieCentreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieCentre::class);
    }

    // /**
    //  * @return CategorieCentre[] Returns an array of CategorieCentre objects
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
    public function findOneBySomeField($value): ?CategorieCentre
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
