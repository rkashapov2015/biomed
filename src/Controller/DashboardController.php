<?php

namespace App\Controller;

use App\Component\{AsteriskMonitor, Helper, RecordFinder};
use App\Entity\AsteriskRecord;
use App\Entity\QueueResult;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Request};
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
    public function search(Request $request, RecordFinder $finder) {

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
    public function reports(Request $request, RecordFinder $finder) {

        if ($request->isXmlHttpRequest()) {

            //$rows = $finder->searchRecords($_POST);
            $statData = $this->getDoctrine()->getRepository(AsteriskRecord::class)->getDataForReport($_POST);

            //$rows = $finder-
            $rows = $this->getDoctrine()->getRepository(AsteriskRecord::class)->getCountRecordsforGraphic($_POST);


            //$resultData = [];
            $resultData = [
                'stat' => $statData,
                'graphic' => [
                    'dates' => array_column($rows, 'date'),
                    'data' => array_column($rows, 'number_calls')
                ],
                'rows' => $rows
            ];



            return new JsonResponse($resultData);
        }

        return $this->render('dashboard/report.html.twig', []);
    }

    public function config() {

    }
}
