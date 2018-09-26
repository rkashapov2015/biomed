<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 25.09.18
 * Time: 17:39
 */

namespace App\Component;

use App\Entity\AsteriskRecord;
use App\Entity\CommonParam;
use Doctrine\Common\Persistence\ManagerRegistry;

class AsteriskImport
{
    protected $urlAsterisk;
    protected $curl;
    protected $manager;

    public function __construct(ManagerRegistry $manager) {

        $this->urlAsterisk = '';
        $this->manager = $manager;
        $urlObject = $this->manager->getRepository(CommonParam::class)->findByName('urlAsterisk');
        if ($urlObject) {
            $this->urlAsterisk = $urlObject->getValue() . '/export.php';
        }

        $this->curl = new CurlyCurly($this->urlAsterisk);
    }

    public function getImport() {
        $lastRecord = $this->manager->getRepository(AsteriskRecord::class)->findLastRecord();

        $postData = null;
        $isPost = false;

        if ($lastRecord) {
            $postData = [
                'uniqueid' => $lastRecord->getUniqueid()
            ];
            print_r($postData);
            $isPost = true;
            echo PHP_EOL;
        }

        if ($this->curl->isReady()) {
            $result = $this->curl->send($postData, $isPost);
            $array = Helper::getJsonData($result);
            $this->saveData($array);

            print_r('count records: ' . count($array));
            echo PHP_EOL;
        }
    }

    protected function saveData($data) {
        if (!$data) {
            return false;
        }
        $entityManager = $this->manager->getManager();
        foreach($data as $row) {
            $object = new AsteriskRecord();
            $object->load($row);
            $entityManager->persist($object);
            $entityManager->flush();
        }

    }

}