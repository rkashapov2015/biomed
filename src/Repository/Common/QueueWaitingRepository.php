<?php

namespace App\Repository\Common;

use App\Entity\Common\QueueWaiting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QueueWaiting|null find($id, $lockMode = null, $lockVersion = null)
 * @method QueueWaiting|null findOneBy(array $criteria, array $orderBy = null)
 * @method QueueWaiting[]    findAll()
 * @method QueueWaiting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QueueWaitingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, QueueWaiting::class);
    }


//    /**
//     * @return QueueWaiting[] Returns an array of QueueWaiting objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QueueWaiting
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
