<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 05.10.18
 * Time: 14:46
 */

namespace App\Repository;

use App\Entity\Hello\Call;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


/**
 * @method Call|null find($id, $lockMode = null, $lockVersion = null)
 * @method Call|null findOneBy(array $criteria, array $orderBy = null)
 * @method Call[]   findAll()
 * @method Call[]   findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CallRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Call::class);
    }

    public function findRecords(array $params) {

        $q = $this->createQueryBuilder('c');
        $q->select(['c.callId id', 'c.src', 'c.startTime calldate', 'c.speakDuration billsec', 'c.answerTime disposition', 'c.operator dst']);

        $direction = 'any';
        if (!empty($params['direction'])) {
            $direction = $params['direction'];
        }
        $phone = '';
        if (!empty($params['phone'])) {
            $phone = $params['phone'];
        }

        $q->where('c.trunk = \'BIOMED\'');

        if ($phone) {
            switch ($direction) {
                case 'incoming':
                    $q->andWhere($q->expr()->like('c.dst', $q->expr()->literal('%' . $phone . '%')));
                    break;
                case 'outgoing':
                    $q->andWhere($q->expr()->like('c.src', $q->expr()->literal('%' . $phone . '%')));
                    break;
                case 'any':
                    $q->andWhere(
                        $q->expr()->orX(
                            $q->expr()->like('c.src', $q->expr()->literal('%' . $phone . '%')),
                            $q->expr()->like('c.dst', $q->expr()->literal('%' . $phone . '%'))
                        )
                    );
            }

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
                $q->andWhere($q->expr()->isNotNull('c.answerTime'));
                break;
            case 'no_answered':
                $q->andWhere($q->expr()->isNull('c.answerTime'));
                break;
            case 'any':
                break;
        }
        $dtStart = new \DateTime($params['start_date']);
        $dtStart->setTime(0,0,0);
        $dtEnd = new \DateTime($params['end_date']);
        $dtEnd->setTime(23,59,59);
        $q->andWhere($q->expr()->between('c.startTime',
            $q->expr()->literal($dtStart->format('Y-m-d H:i:s')),
            $q->expr()->literal($dtEnd->format('Y-m-d H:i:s'))
        ));
        $q->orderBy('c.startTime', 'ASC');

        return $q->getQuery()->getResult();

    }

    public function getDataForReport($params) {
        $dtStart = new \DateTime($params['start_date']);
        $dtStart->setTime(0,0,0);
        $dtEnd = new \DateTime($params['end_date']);
        $dtEnd->setTime(23,59,59);
        $dtStartStr = $dtStart->format('Y.m.d H:i:s');
        $dtEndStr = $dtEnd->format('Y.m.d H:i:s');

        $sql = "SELECT
        SUM(1) number_of_records,
        sum(case when c.start_time::time between '7:00:00'::time and '22:00:00'::time then 1 else 0 end) work_time,
        sum(case when c.answer_time is not null then 1 else 0 end) answered,
        sum(case when c.answer_time is null then 1 else 0 end) not_answered,
        ROUND(avg(extract(epoch from (c.answer_time - c.start_time)))::numeric,2) time_take_phone,
        ROUND((max(extract( epoch from (c.answer_time - c.start_time))))::numeric,2) max_time_take_phone,
        ROUND(AVG(c.call_duration), 2) average_time,
        ROUND((MAX(c.call_duration)),2) max_time,
        SUM(c.call_duration)/60 summ_duration
        FROM main.call c
        WHERE c.start_time BETWEEN '{$dtStartStr}' AND '{$dtEndStr}' and c.trunk = 'BIOMED'";

        $connection = $this->getEntityManager()->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();

    }

    public function getCountRecordsforGraphic($params) {
        $dtStart = new \DateTime($params['start_date']);
        $dtStart->setTime(0,0,0);
        $dtEnd = new \DateTime($params['end_date']);
        $dtEnd->setTime(23,59,59);
        $dtStartStr = $dtStart->format('Y.m.d H:i:s');
        $dtEndStr = $dtEnd->format('Y.m.d H:i:s');

        $sql = "
        SELECT 
            DATE_FORMAT(d.date, \"%d.%m.%Y\") as 'date',
            d.number_calls
        FROM
        (
            SELECT DATE(ar.start_time) as 'date', count(ar.uniqueid) as 'number_calls'
            FROM biomed.asterisk_record ar
            WHERE ar.calldate BETWEEN '{$dtStartStr}' AND '{$dtEndStr}'
            GROUP BY DATE(ar.calldate)
        ) d
        ORDER BY d.date ASC";

        $connection = $this->getEntityManager()->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}