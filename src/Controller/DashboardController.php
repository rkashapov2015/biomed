<?php

namespace App\Controller;

use App\Component\{AsteriskImport, AsteriskMonitor, CallFinder, RecordFinder};
use App\Entity\Common\{AsteriskRecord, QueueResult};
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

    public function config() {

    }
}
