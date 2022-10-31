<?php

namespace App\Repository;

use App\Entity\Formulaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Formulaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formulaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formulaire[]    findAll()
 * @method Formulaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormulaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formulaire::class);
    }

    // /**
    //  * @return Formulaire[] Returns an array of Formulaire objects
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
    public function findOneBySomeField($value): ?Formulaire
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function listOrderBycin()
    {
        return $this->createQueryBuilder('k')
            ->orderBy('k.cin','ASC')
            ->getQuery()->getResult();


    }
    public function rechercher($cin)
    {
        return $this->createQueryBuilder('l')
            ->where('l.cin Like :cin')
            ->setParameter('cin','%'.$cin.'%')
            ->getQuery()
            ->execute();
    }
    public function getPaginateform($page,$limit){
        $query=$this->createQueryBuilder('f')
            ->orderBy('f.ref')
            ->setFirstResult(($page*$limit)-$limit)
            ->setMaxResults($limit);
        return $query->getQuery()
            ->getResult();

    }
    public function getTotalform()
    {
        $query=$this->createQueryBuilder('f')
            ->select('COUNT(f)');
        return $query->getQuery()
            ->getSingleScalarResult();
    }
}
