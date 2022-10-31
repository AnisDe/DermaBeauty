<?php

namespace App\Repository;

use App\Entity\FormCateg;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FormCateg|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormCateg|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormCateg[]    findAll()
 * @method FormCateg[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormCategRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormCateg::class);
    }

    // /**
    //  * @return FormCateg[] Returns an array of FormCateg objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FormCateg
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
