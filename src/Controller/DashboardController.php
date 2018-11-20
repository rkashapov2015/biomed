<?php

namespace App\Controller;

use App\Component\{AsteriskImport, AsteriskMonitor, CallFinder, OptimizerCallStat, RecordFinder};
use App\Entity\Common\{AsteriskRecord, QueueResult, QueueWaiting};
use App\Entity\Hello\Call;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{BinaryFileResponse, JsonResponse, Request, Response};
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index() {
        return $this->render('dashboard/index.html.twig', []);
    }

    /**
     * @Route("/dashboard/monitoring", name="monitoring")
     */
    public function monitoring(AsteriskMonitor $monitor, Request $request) {

        //$monitor = new AsteriskMonitor($this->getDoctrine());

        $data = $this->getDoctrine()->getRepository(QueueResult::class)->getDataFromAsterisk();

        if ($request->isXmlHttpRequest()) {

            return new JsonResponse([
                'data' => $data
            ]);
        }

        //$data = $monitor->getMonitorData();
        return $this->render('dashboard/monitor.html.twig', [
            'data' => $data
        ]);
    }

    /**
     * @Route("/dashboard/search", name="search")
     */
    //public function search(Request $request, RecordFinder $finder) {
    public function search(Request $request, CallFinder $finder) {

        if ($request->isXmlHttpRequest()) {

            $result = $finder->searchRecords($_POST);

            $responseData = [
                'rows' => [],
            ];
            //if (!empty($result) && is_array($result)) {
                //$responseData = ['rows' => $result];
                $responseData = [
                    'rows' => $result
                ];
            //}
            return new JsonResponse($responseData);
        }

        return $this->render('dashboard/search.html.twig', []);
    }

    /**
     * @Route("/dashboard/reports", name="reports")
     */
    public function reports(Request $request, CallFinder $finder) {
    //public function reports(Request $request) {

        if ($request->isXmlHttpRequest()) {

            //$rows = $finder->searchRecords($_POST);
            //$statData = $this->getDoctrine()->getRepository(AsteriskRecord::class)->getDataForReport($_POST);
            $statData = $this->getDoctrine()->getRepository(Call::class, 'helloasterisk')->getDataForReport($_POST);

            //$rows = $finder-
            $rows = $this->getDoctrine()->getRepository(Call::class, 'helloasterisk')->getCountRecordsforGraphic($_POST);

            $rowsWaiting = $this->getDoctrine()->getRepository(QueueWaiting::class)->getInfoForReport($_POST);
            if ($statData && $rowsWaiting) {
                $statData[0]['max_waiting'] = intval(max(array_column($rowsWaiting, 'max_queue')));
            }
            $type = '';
            $forDay = false;
            if ($_POST['start_date'] == $_POST['end_date']) {
                $forDay = true;
                $type = 'line';
            } else {
                $type = 'bar';
            }

            $summ = array_column($rows, 'summ');
            $answered = array_column($rows, 'answered');
            $not_answered = array_column($rows, 'not_answered');

//            //////////////////
//            if ($statData && $rows) {
//
//
//                $optimizer = new OptimizerCallStat($answered, $not_answered);
//                if (!$forDay) {
//                    $optimizer->setRangeMode();
//                }
//                $optimizer->setDesiredPercent(5);
//                $optimizer->calculate();
//                $not_answered = $optimizer->getNotAnswered();
//
//                $summ = array_map(function ($a, $b) {
//                    return $a + $b;
//                }, $answered, $not_answered);
//
//
//                $statData[0]['number_of_records'] =  array_sum($summ);
//                $statData[0]['not_answered'] = array_sum($not_answered);
//            }

            ///////////////////

            $resultData = [
                'stat' => $statData,
                'graphic' => [
                    'dates' => array_column($rows, 'date_name'),
                    //'data' => array_column($rows, 'number_calls')
                    'type' => $type,
                    'data' => [
                        'summ' => $summ,
                        'answered' => $answered,
                        'not_answered' => $not_answered,
                        'waiting' => array_column($rowsWaiting, 'max_queue')
                    ]
                ],
                'rows' => $rows
            ];



            return new JsonResponse($resultData);
        }

        return $this->render('dashboard/report.html.twig', []);
    }


    /**
     * @Route("/dashboard/reports-not-answered", name="reports_not_answered")
     */
    public function notAnswered(Request $request, CallFinder $finder) {
        //public function reports(Request $request) {

        if ($request->isXmlHttpRequest()) {

            $statData = $this->getDoctrine()->getRepository(Call::class, 'helloasterisk')->getDataForReport($_POST);
            //$rows = $finder-
            $rows = $this->getDoctrine()->getRepository(Call::class, 'helloasterisk')->getNotAnsweredRange($_POST);

            $rowsWaiting = $this->getDoctrine()->getRepository(QueueWaiting::class)->getInfoForReport($_POST);
            if ($statData && $rowsWaiting) {
                $statData[0]['max_waiting'] = intval(max(array_column($rowsWaiting, 'max_queue')));
            }
            $type = '';
            $forDay = false;
            if ($_POST['start_date'] == $_POST['end_date']) {
                $forDay = true;
                $type = 'line';
            } else {
                $type = 'bar';
            }

            $summ = array_column($rows, 'summ');
            $s5 = array_column($rows, 's5');
            $s10 = array_column($rows, 's10');
            $s15 = array_column($rows, 's15');
            $s20 = array_column($rows, 's20');
            $s25 = array_column($rows, 's25');
            $s30p = array_column($rows, 's30p');

            $resultData = [
                'stat' => $statData,
                'graphic' => [
                    'dates' => array_column($rows, 'date_name'),
                    //'data' => array_column($rows, 'number_calls')
                    'type' => $type,
                    'data' => [
                        'summ' => $summ,
                        's5' => $s5,
                        's10' => $s10,
                        's15' => $s15,
                        's20' => $s20,
                        's25' => $s25,
                        's30p' => $s30p
                    ]
                ],
                'rows' => $rows
            ];

            return new JsonResponse($resultData);
        }

        return $this->render('dashboard/report_not_answered.html.twig', []);
    }

    /**
     * @Route("/dashboard/sound", name="sound")
     */
    public function sound(Request $request, AsteriskImport $asteriskImport) {
        $id = $request->get('id');

        $model = $this->getDoctrine()->getRepository(AsteriskRecord::class)->findOneBy(['id' => $id]);

        if (empty($model)) {
            return new Response('');
        }

        $uniqueid = $model->getUniqueid();
        $filePath = $asteriskImport->getSoundByUniqueid($uniqueid);

        if ($filePath) {
            return new BinaryFileResponse($filePath);
            //return new Response($filePath);
        }
        return new Response('');
    }

    /**
     * @param Request $request
     * @param AsteriskImport $asteriskImport
     * @return BinaryFileResponse|Response
     *
     * @Route("/dashboard/sound-ha", name="sound-ha")
     */
    public function soundHa(Request $request, AsteriskImport $asteriskImport) {
        $id = $request->get('id');

        $model = $this->getDoctrine()->getRepository(Call::class, 'helloasterisk')->findOneBy(['callId' => $id]);

        if (empty($model)) {
            return new Response('');
        }

        $uniqueid = $model->getLinkedid();
        $filePath = $asteriskImport->getSoundByUniqueid($uniqueid);

        if ($filePath) {
            return new BinaryFileResponse($filePath);
            //return new Response($filePath);
        }
        return new Response('');
    }

    public function config() {

    }
}
