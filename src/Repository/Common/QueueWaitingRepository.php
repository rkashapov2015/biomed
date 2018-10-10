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

    public function getInfoForReport($params) {
        $dtStart = new \DateTime($params['start_date']);
        $dtStart->setTime(0,0,0);
        $dtEnd = new \DateTime($params['end_date']);
        $dtEnd->setTime(23,59,59);
        $dtStartStr = $dtStart->format('Y.m.d H:i:s');
        $dtEndStr = $dtEnd->format('Y.m.d H:i:s');

        $sql = "";

        $sqlForDay = "
            SELECT time_point, max_queue
            FROM biomed.queue_waiting
            where time_point between '{$dtStartStr}' and '{$dtEndStr}'";

        $sqlForInterval = "
            SELECT DATE_FORMAT(time_point, '%Y-%m-%d') as time_point, max(max_queue) as max_queue
            FROM biomed.queue_waiting
            where time_point between '{$dtStartStr}' and '{$dtEndStr}'
            group by 1";

        if ($params['start_date'] == $params['end_date']) {
            $sql = $sqlForDay;
        } else {
            $sql = $sqlForInterval;
        }

        $connection = $this->getEntityManager()->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
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
