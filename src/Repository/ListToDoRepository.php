<?php

namespace App\Repository;

use App\Entity\ListToDo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ListToDo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListToDo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListToDo[]    findAll()
 * @method ListToDo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListToDoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListToDo::class);
    }

    // /**
    //  * @return ListToDo[] Returns an array of ListToDo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListToDo
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
