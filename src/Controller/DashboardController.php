<?php

namespace App\Controller;

use App\Component\AsteriskMonitor;
use App\Component\Helper;
use App\Entity\QueueResult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
    public function search(Request $request) {

        if ($request->isXmlHttpRequest()) {

            return new JsonResponse($_POST);
        }

        return $this->render('dashboard/search.html.twig', []);
    }

    /**
     * @Route("/dashboard/reports", name="reports")
     */
    public function reports() {
        return $this->render('dashboard/index.html.twig', []);
    }

    public function config() {

    }
}
