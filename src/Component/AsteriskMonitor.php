<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 20.09.18
 * Time: 12:22
 */

namespace App\Component;


use App\Entity\Common\CommonParam;
use Doctrine\Common\Persistence\ManagerRegistry;

class AsteriskMonitor
{
    protected $urlAsterisk;
    protected $curl;
    protected $manager;
    protected $monitorData;

    public function __construct(ManagerRegistry $manager) {

        $this->urlAsterisk = '';
        $this->manager = $manager;
        $urlObject = $this->manager->getRepository(CommonParam::class)->findByName('urlAsterisk');
        if ($urlObject) {
            $this->urlAsterisk = $urlObject->getValue() . '/monitor.php';
        }


        $this->curl = new CurlyCurly($this->urlAsterisk);
    }

    public function getMonitorData() {
        if ($this->curl->isReady()) {
            $result = $this->curl->send(null, false);

            return $result;
        }
        return [];
    }

}