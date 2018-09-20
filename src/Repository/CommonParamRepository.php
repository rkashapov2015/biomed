<?php

namespace App\Repository;

use App\Entity\CommonParam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommonParam|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommonParam|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommonParam[]    findAll()
 * @method CommonParam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommonParamRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommonParam::class);
    }

    /**
     * @return CommonParam Returns an array of CommonParam objects
     */

    public function findByName($name) {
        return $this->createQueryBuilder('c')
            ->andWhere('c.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return CommonParam[] Returns an array of CommonParam objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommonParam
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
