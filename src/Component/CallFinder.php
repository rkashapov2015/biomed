<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 27.09.18
 * Time: 13:56
 */

namespace App\Component;

use App\Entity\Hello\Call;
use Doctrine\Common\Persistence\ManagerRegistry;


class CallFinder
{
    protected $manager;

    protected $start_date;
    protected $end_date;

    public function __construct(ManagerRegistry $manager) {
        $this->manager = $manager;
    }

    public function searchRecords($params)
    {
        $this->loadParams($params);

        if (!$this->checkParams()) {
            return [];
        }

        $rows = $this->manager->getRepository(Call::class, 'helloasterisk')->findRecords($params);
        foreach ($rows as &$row) {
            $dt = $row['calldate'];
            $row['calldate'] = $dt->format('d.m.Y H:i:s');
        }
        return $rows;
    }

    public function loadParams($params)
    {
        if (!is_array($params)) {
            return false;
        }
        foreach ($params as $key => $value) {
            if (property_exists(RecordFinder::class, $key)) {
                $this->$key = $value;
            }
        }
        return true;
    }

    protected function checkParams() {
        $dtStart = new \DateTime($this->start_date);
        $dtEnd = new \DateTime($this->end_date);
        $result = true;
        if ($dtStart > $dtEnd) {
            $result = false;
        }

        return $result;
    }

}