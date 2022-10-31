<?php

namespace App\Repository;

use App\data\SearchData;
use App\Entity\Forum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Forum|null find($id, $lockMode = null, $lockVersion = null)
 * @method Forum|null findOneBy(array $criteria, array $orderBy = null)
 * @method Forum[]    findAll()
 * @method Forum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForumRepository extends ServiceEntityRepository
{private $paginator;
    public function __construct(ManagerRegistry $registry,PaginatorInterface $paginator)
    {
        parent::__construct($registry, Forum::class);
        $this->paginator = $paginator;
    }


    public function selectData(SearchData $data){
        $query=$this->createQueryBuilder('p');
            if(!empty($data->q)){
               $query = $query->andWhere('p.titre LIKE :q')
                   ->setParameter('q',"%{$data->q}%");

            }
        if($data->cat_id!=null){
            $query = $query->andWhere('p.sujet = :id')->setParameter(':id',$data->cat_id);


        }
            $query = $query->getQuery();
            return $this->paginator->paginate(
                $query,$data->page,6
            );
    }
    public function selectDataWithSujet(SearchData $data,$id){
        $query=$this->createQueryBuilder('p')->where('p.sujet = :id')->setParameter('id',$id);

        if(!empty($data->q)){
            $query = $query->andWhere('p.titre LIKE :q')
                ->setParameter('q',"%{$data->q}%");

        }


        $query = $query->getQuery();

        return $this->paginator->paginate(
            $query,$data->page,6
        );
    }

    // /**
    //  * @return Forum[] Returns an array of Forum objects
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
    public function findOneBySomeField($value): ?Forum
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
