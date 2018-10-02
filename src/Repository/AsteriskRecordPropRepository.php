<?php

namespace App\Repository;

use App\Entity\AsteriskRecordProp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AsteriskRecordProp|null find($id, $lockMode = null, $lockVersion = null)
 * @method AsteriskRecordProp|null findOneBy(array $criteria, array $orderBy = null)
 * @method AsteriskRecordProp[]    findAll()
 * @method AsteriskRecordProp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AsteriskRecordPropRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AsteriskRecordProp::class);
    }

    public function findLastRecord() {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }


//    /**
//     * @return AsteriskRecordProp[] Returns an array of AsteriskRecordProp objects
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
    public function findOneBySomeField($value): ?AsteriskRecordProp
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
