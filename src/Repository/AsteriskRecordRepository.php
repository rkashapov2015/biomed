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

    public function findRecords(array $params) {

        $q = $this->createQueryBuilder('a');


        $q->select(['a.calldate', 'a.src', 'a.dst', 'a.billsec', 'a.disposition']);

        $direction = 'any';
        if (!empty($params['direction'])) {
            $direction = $params['direction'];
        }
        $phone = '';
        if (!empty($params['phone'])) {
            $phone = $params['phone'];
        }

        if ($phone) {
            switch ($direction) {
                case 'incoming':
                    //$q->andWhere('a.dst like \'%:phone%\'');
                    $q->andWhere($q->expr()->like('a.dst', $q->expr()->literal('%' . $phone . '%')));
                    break;
                case 'outgoing':
                    $q->andWhere($q->expr()->like('a.src', $q->expr()->literal('%' . $phone . '%')));
                    //$q->andWhere('a.src like \'%:phone%\'');

                    break;
                case 'any':
                    $q->andWhere(
                        $q->expr()->orX(
                            $q->expr()->like('a.src', $q->expr()->literal('%' . $phone . '%')),
                            $q->expr()->like('a.dst', $q->expr()->literal('%' . $phone . '%'))
                        )

                    );
                    //$q->andWhere('(a.src like \'%:phone%\' OR a.dst like \'%:phone%\')');
            }
            //$q->setParameter('phone', $phone);
        }

        $limit = 100;
        if (!empty($params['limit'])) {
            $limit = intval($params['limit']);
        }
        if (!empty($params['number_of_records'])) {
            $limit = intval($params['number_of_records']);
        }
        $q->setMaxResults($limit);

        $status = 'answered';
        if (!empty($params['status'])) {
            $status = $params['status'];
        }

        switch ($status) {
            case 'answered':
                $q->andWhere($q->expr()->eq('a.disposition', $q->expr()->literal('ANSWERED')));

                break;
            case 'no_answered':
                $q->andWhere($q->expr()->neq('a.disposition', $q->expr()->literal('ANSWERED')));

                break;
            case 'any':
                break;
        }
        $dtStart = new \DateTime($params['start_date']);
        $dtStart->setTime(0,0,0);
        $dtEnd = new \DateTime($params['end_date']);
        $dtEnd->setTime(23,59,59);
        $q->andWhere($q->expr()->between('a.calldate',
            $q->expr()->literal($dtStart->format('Y-m-d H:i:s')),
            $q->expr()->literal($dtEnd->format('Y-m-d H:i:s'))
        ));
        $q->orderBy('a.calldate', 'ASC');

        return $q->getQuery()->getResult();
        //return $q->getQuery();
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
