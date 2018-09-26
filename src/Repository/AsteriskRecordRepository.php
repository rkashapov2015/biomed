<?php

namespace App\Repository;

use App\Entity\AsteriskRecord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AsteriskRecord|null find($id, $lockMode = null, $lockVersion = null)
 * @method AsteriskRecord|null findOneBy(array $criteria, array $orderBy = null)
 * @method AsteriskRecord[]    findAll()
 * @method AsteriskRecord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AsteriskRecordRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AsteriskRecord::class);
    }

    public function findLastRecord() {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return AsteriskRecord[] Returns an array of AsteriskRecord objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AsteriskRecord
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
