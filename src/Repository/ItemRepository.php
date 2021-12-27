<?php

namespace App\Repository;

use App\Entity\Item;
use Carbon\Carbon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    // /**
    //  * @return Item[] Returns an array of Item objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Item
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findLastItemIfGreaterThan30Minutes($listToDoId)
    {
        // automatically knows to select Products
        // the "i" is an alias you'll use in the rest of the query

        $dateBefore = Carbon::now()->subMinutes(30)->format('Y-m-d\TH:i:s');
        $dateNow = Carbon::now()->format('Y-m-d\TH:i:s');
        $qb = $this->createQueryBuilder('i')
            ->where('i.listToDo = :listToDoId')
            ->andWhere('i.creation_date >= :dateBefore')
            ->andWhere('i.creation_date <= :dateNow')
            ->setParameter('listToDoId', $listToDoId)
            ->setParameter('dateBefore', $dateBefore)
            ->setParameter('dateNow', $dateNow);

        $query = $qb->getQuery();
        return $query->getResult();

        // to get just one result:
        // $product = $query->setMaxResults(1)->getOneOrNullResult();
    }
}
