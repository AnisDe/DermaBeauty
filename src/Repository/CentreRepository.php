<?php

namespace App\Repository;

use App\Entity\Centre;
use App\Entity\Search;
use App\Form\SearchType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;
use ProxyManager\ProxyGenerator\Util\Properties;

/**
 * @method Centre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Centre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Centre[]    findAll()
 * @method Centre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CentreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Centre::class);
    }

    /**
     * @return Centre[]
     */
    public function findSearch(\App\Data\Search $search):array
    {
        $query = $this
            ->createQueryBuilder('p')
            ->select('c' ,'p')
            ->join('p.categorie' , 'c');


            if ( !empty($search->q)){
                $query =$query ->andWhere('p.nom LIKE :q')->setParameter('q' ,"%{$search->q}%");
            }
        if ( !empty($search->categories)){
            $query =$query ->andWhere('c.id IN (:categories)')->setParameter('categories' , $search->categories);
        }
        return $query->getQuery()->getResult();
    }
}
