<?php

namespace App\Repository;

use App\Data\SearchProd;
use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }
    public function findBycath($id){
        $query = $this->createQueryBuilder('p');

        $query = $query->where('p.Categorie = :id')->setParameter(':id',$id)->orderBy('p.Quantite_V','DESC');




        return $query->getQuery()->getResult();




    }

     /**
      * @return Produit[] Returns an array of Produit objects
      */

   public function findByMarque($marque)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.Marque_P = :marque')
            ->setParameter(':marque', $marque)
            ->orderBy('p.Quantite_V', 'DESC')
          //  ->setMaxResults(12)
            ->getQuery()
            ->getResult()
        ;
    }



    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    public function OrderBySale(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select p from App\Entity\Produit p order by p.Quantite_V DESC'
        );
            return $query->getResult();
    }

    public function OrderByPriceUP(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select p from App\Entity\Produit p order by p.Prix_P ASC'
        );
        return $query->getResult();
    }
    public function getTotalProd()
    {
        $query=$this->createQueryBuilder('p')
            ->select('COUNT(p)');
        return $query->getQuery()
            ->getSingleScalarResult();
    }
    public function getPaginateProd($page,$limit){
        $query=$this->createQueryBuilder('p')

            ->setFirstResult(($page*$limit)-$limit)
            ->setMaxResults($limit);
        return $query->getQuery()
            ->getResult();

    }

    /**
     * @return Produit[] Returns an array of Produit objects
     */

    public function findsearch(SearchProd $search):array
    {
        $query=$this

            ->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.Quantite_V','DESC');
        if(!empty($search->q)){
            $query=$query
                ->andWhere('p.Marque_P LIKE :q')
                ->setParameter('q',"%{$search->q}%")
                ->orderBy('p.Quantite_V','DESC');


        }
        if (!empty($search->min)){
            $query=$query
                ->andWhere('p.Prix_P >= :min')
                ->setParameter('min',$search->min)
                ->orderBy('p.Quantite_V','DESC');

        }
        if (!empty($search->max)){
            $query=$query
                ->andWhere('p.Prix_P <= :max')
                ->setParameter('max',$search->max)
                ->orderBy('p.Quantite_V','DESC');

        }

        return $query->getQuery()->getResult();


    }

}
