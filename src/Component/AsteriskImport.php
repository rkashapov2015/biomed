<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 25.09.18
 * Time: 17:39
 */

namespace App\Component;

use App\Entity\AsteriskRecord;
use App\Entity\AsteriskRecordProp;
use App\Entity\CommonParam;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
            $this->urlAsterisk = $urlObject->getValue();
        }
    }

    public function getImport() {

        $this->curl = new CurlyCurly($this->urlAsterisk  . '/export.php');
        $lastRecord = $this->manager->getRepository(AsteriskRecord::class)->findLastRecord();

        $postData = null;
        $isPost = false;

        if ($lastRecord) {
            $postData = [
                'id_asterisk' => $lastRecord->getIdAsterisk()
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
        return true;
    }

    public function getImportProp() {

        $this->curl = new CurlyCurly($this->urlAsterisk  . '/export_prop.php');
        $lastRecord = $this->manager->getRepository(AsteriskRecordProp::class)->findLastRecord();

        $postData = null;
        $isPost = false;

        if ($lastRecord) {
            $postData = [
                'id_asterisk' => $lastRecord->getIdAsterisk()
            ];
            print_r($postData);
            $isPost = true;
            echo PHP_EOL;
        }

        if ($this->curl->isReady()) {
            $result = $this->curl->send($postData, $isPost);
            $array = Helper::getJsonData($result);
            $this->saveDataProp($array);

            print_r('count records: ' . count($array));
            echo PHP_EOL;
        }
    }

    protected function saveDataProp($data) {
        if (!$data) {
            return false;
        }
        $entityManager = $this->manager->getManager();
        foreach($data as $row) {
            $object = new AsteriskRecordProp();
            $object->load($row);
            $entityManager->persist($object);
            $entityManager->flush();
        }
        return true;
    }

    public function getSoundByUniqueid($uniqueid) {
        $this->curl = new CurlyCurly($this->urlAsterisk  . '/records.php');
        if (!$uniqueid) {
            throw new NotFoundHttpException('Unique id not exist');
        }
        $path = '/var/spool/biomed/';
        $filename = $uniqueid . '.wav';
        $fullpath = $path . $filename;


        if (file_exists($fullpath)) {
            return $fullpath;
        }

        $result = $this->curl->send(['uniqueid' => $uniqueid ]);
        if (strlen($result)) {
            if (file_put_contents($fullpath, $result)) {
                return $fullpath;
            }
            return $fullpath;
        }
        return false;
    }

}