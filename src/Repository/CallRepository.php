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

    private $minSeconds = 50;

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
                    $q->andWhere($q->expr()->like('c.src', $q->expr()->literal('%' . $phone . '%')));
                    break;
                case 'outgoing':
                    $q->andWhere($q->expr()->like('c.operator', $q->expr()->literal('%' . $phone . '%')));
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
        to_char(ROUND(avg(extract(epoch from (c.answer_time - c.start_time)))::numeric,0) * '1 second'::interval, 'MI:SS') time_take_phone,
        to_char(ROUND((max(extract( epoch from (c.answer_time - c.start_time))))::numeric,0) * '1 second'::interval, 'MI:SS') max_time_take_phone,
        to_char(ROUND(AVG(c.speak_duration), 0) * '1 second'::interval, 'MI:SS') average_time,
        to_char(ROUND((MAX(c.speak_duration)),0) * '1 second'::interval, 'MI:SS') max_time,
        --to_char(SUM(c.speak_duration)* '1 second'::interval, 'HH24:MI:SS') summ_duration
        CONCAT((SUM(c.speak_duration)/60)::text, ':'::text, (SUM(c.speak_duration)%60)::text) summ_duration
        FROM main.call c
        WHERE c.start_time BETWEEN '{$dtStartStr}' AND '{$dtEndStr}' and c.trunk = 'BIOMED' and 
        ((c.answer_time is not null and c.call_duration > 1) or (c.answer_time is null and c.call_duration > :seconds))";

        $connection = $this->getEntityManager()->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute(['seconds' => $this->minSeconds]);
        return $stmt->fetchAll();

    }

    public function getCountRecordsforGraphic($params) {
        $dtStart = new \DateTime($params['start_date']);
        $dtStart->setTime(0,0,0);
        $dtEnd = new \DateTime($params['end_date']);
        $dtEnd->setTime(23,59,59);
        $dtStartStr = $dtStart->format('Y.m.d H:i:s');
        $dtEndStr = $dtEnd->format('Y.m.d H:i:s');

        $sql = '';


        $sqlForDay = "
            WITH cte AS (
                select
                    date_trunc('hour', x.start_time) date_hour,
                    to_char(date_trunc('hour', x.start_time), 'HH24:MI') date_name,
                    sum(1) summ,
                    sum(case when x.answer_time is not null then 1 else 0 end) answered,
                    sum(case when x.answer_time is null then 1 else 0 end) not_answered 
                FROM main.call x
                WHERE x.start_time between '{$dtStartStr}' and '{$dtEndStr}' and x.trunk = 'BIOMED' and 
                ((x.answer_time is not null and x.call_duration > 6) or (x.answer_time is null and x.call_duration > :seconds))
                group by date_trunc('hour', x.start_time)
                order by date_trunc('hour', x.start_time) asc
            )
            SELECT
                COALESCE(to_char(date_trunc('hour', cte.date_hour), 'HH24:MI'), to_char(date_trunc('hour', m.date_hour), 'HH24:MI')) date_name,
                COALESCE(cte.answered, 0) answered,
                COALESCE(cte.not_answered, 0) not_answered
            FROM  (
                SELECT generate_series(min(cte.date_hour), max(cte.date_hour), interval '1 hour') FROM cte
            ) m(date_hour)
            left JOIN cte USING(date_hour)";

        $sqlForInterval = "select
            to_char(x.start_time, 'DD.MM.YYYY') date_name,
            sum(1) summ,
            sum(case when x.answer_time is not null then 1 else 0 end) answered,
            sum(case when x.answer_time is null then 1 else 0 end) not_answered 
        FROM main.call x
        WHERE x.start_time between '{$dtStartStr}' and '{$dtEndStr}' and x.trunk = 'BIOMED' and 
        ((x.answer_time is not null and x.call_duration > 1) or (x.answer_time is null and x.call_duration > :seconds))
        group by to_char(x.start_time, 'DD.MM.YYYY')
        order by to_char(x.start_time, 'DD.MM.YYYY')";

        if ($params['start_date'] == $params['end_date']) {
            $sql = $sqlForDay;
        } else {
            $sql = $sqlForInterval;
        }

        $connection = $this->getEntityManager()->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute(['seconds' => $this->minSeconds]);
        return $stmt->fetchAll();
    }

    public function getWaitingInQueueByDay(string $date) {
        $dt = new \DateTime($date);
        $dtStart = $dt->format('Y-m-d');
        $dtEnd = $dtStart;
        $sql = "
        WITH cte AS (
           select
            date_trunc('hour', start_time) AS day_start,
            date_trunc('second', start_time) AS second_start,   	 
            date_trunc('second', coalesce(answer_time, end_time)) AS second_end, 
            count(*) AS second_ct
           FROM main.call where trunk = 'BIOMED' and start_time between '{$dtStart} 00:00:00' and '{$dtEnd} 23:59:59' 
           group BY 1,2,3
           order by 1
        )
        select
            dd.sec_start time_point,
            round(avg(dd.running_ct),2) avg_queue,
            max(dd.running_ct) max_queue
        from (
            SELECT 
                cte.day_start, 
                date_trunc('hour', m.second_start) sec_start,
                cte.second_end,
                COALESCE(sum(cte.second_ct) OVER (partition BY cte.day_start, m.second_start), 0) AS running_ct
            FROM  (
               SELECT generate_series(min(second_start), max(second_end), interval '2 sec')
               FROM cte
            ) m(second_start)
            LEFT JOIN cte on m.second_start between cte.second_start and cte.second_end
        ) dd
        group by 1
        order by 1";
        $connection = $this->getEntityManager()->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function prepareWaitingData(\DateTimeInterface $dt) {
        $dtStr = $dt->format('Y-m-d');
        $sql = "
        WITH cte AS (
            select
                date_trunc('hour', start_time) AS day_start,
                date_trunc('second', start_time) AS second_start,
                date_trunc('second', coalesce(answer_time, end_time)) AS second_end,
                count(*) AS second_ct
            FROM main.call where trunk = 'BIOMED' and start_time between '{$dtStr} 00:00:00' and '{$dtStr} 23:59:59'
            group BY 1,2,3
            order by 1
        )
        select
            dd.sec_start time_point,
            round(avg(dd.running_ct),2) avg_queue,
            max(dd.running_ct) max_queue
        from (
            SELECT
                cte.day_start,
                date_trunc('hour', m.second_start) sec_start,
                cte.second_end,
                COALESCE(sum(cte.second_ct) OVER (partition BY cte.day_start, m.second_start), 0) AS running_ct
            FROM  (
               SELECT generate_series(min(second_start), '{$dtStr} 21:00:00', interval '2 sec')
               FROM cte
            ) m(second_start)
            LEFT JOIN cte on m.second_start between cte.second_start and cte.second_end
        ) dd
        group by 1
        order by 1";

        $connection = $this->getEntityManager()->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getNotAnsweredRange($params)
    {
        $dtStart = new \DateTime($params['start_date']);
        $dtStart->setTime(0,0,0);
        $dtEnd = new \DateTime($params['end_date']);
        $dtEnd->setTime(23,59,59);
        $dtStartStr = $dtStart->format('Y.m.d H:i:s');
        $dtEndStr = $dtEnd->format('Y.m.d H:i:s');

        $sqlForDay = "
        WITH cte AS (
            select
                date_trunc('hour', x.start_time) date_hour,
                to_char(date_trunc('hour', x.start_time), 'HH24:MI') date_name,
                sum(1) summ,
                sum(case when x.answer_time is null and x.call_duration between 50 and 55 then 1 else 0 end) s5, 
                sum(case when x.answer_time is null and x.call_duration between 56 and 60 then 1 else 0 end) s10,
                sum(case when x.answer_time is null and x.call_duration between 61 and 65 then 1 else 0 end) s15,
                sum(case when x.answer_time is null and x.call_duration between 66 and 70 then 1 else 0 end) s20,
                sum(case when x.answer_time is null and x.call_duration between 71 and 75 then 1 else 0 end) s25,
                sum(case when x.answer_time is null and x.call_duration > 76 then 1 else 0 end) s30p
            FROM main.call x
            WHERE x.start_time between '{$dtStartStr}' and '{$dtEndStr}' and x.trunk = 'BIOMED' and 
            ((x.answer_time is not null and x.call_duration > 6) or (x.answer_time is null and x.call_duration > :seconds))
            group by date_trunc('hour', x.start_time)
            order by date_trunc('hour', x.start_time) asc
        )
        SELECT
            COALESCE(to_char(date_trunc('hour', cte.date_hour), 'HH24:MI'), to_char(date_trunc('hour', m.date_hour), 'HH24:MI')) date_name,
            COALESCE(cte.summ, 0) summ,
            COALESCE(cte.s5, 0) s5,
            COALESCE(cte.s10, 0) s10,
            COALESCE(cte.s15, 0) s15,
            COALESCE(cte.s20, 0) s20,
            COALESCE(cte.s25, 0) s25,
            COALESCE(cte.s30p, 0) s30p
        FROM  (
            SELECT generate_series(min(cte.date_hour), max(cte.date_hour), interval '1 hour') FROM cte
        ) m(date_hour)
        left JOIN cte USING(date_hour)
        ";
        $sqlForInterval = "
        select
            to_char(x.start_time, 'DD.MM.YYYY') date_name,
            sum(1) summ,
            sum(case when x.answer_time is null and x.call_duration between 50 and 55 then 1 else 0 end) s5, 
            sum(case when x.answer_time is null and x.call_duration between 56 and 60 then 1 else 0 end) s10,
            sum(case when x.answer_time is null and x.call_duration between 61 and 65 then 1 else 0 end) s15,
            sum(case when x.answer_time is null and x.call_duration between 66 and 70 then 1 else 0 end) s20,
            sum(case when x.answer_time is null and x.call_duration between 71 and 75 then 1 else 0 end) s25,
            sum(case when x.answer_time is null and x.call_duration > 76 then 1 else 0 end) s30p 
        FROM main.call x
        WHERE x.start_time between '{$dtStartStr}' and '{$dtEndStr}' and x.trunk = 'BIOMED' and 
        ((x.answer_time is not null and x.call_duration > 1) or (x.answer_time is null and x.call_duration > :seconds))
        group by to_char(x.start_time, 'DD.MM.YYYY')
        order by to_char(x.start_time, 'DD.MM.YYYY')";

        if ($params['start_date'] == $params['end_date']) {
            $sql = $sqlForDay;
        } else {
            $sql = $sqlForInterval;
        }

        $connection = $this->getEntityManager()->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute(['seconds' => $this->minSeconds]);
        return $stmt->fetchAll();
    }
}