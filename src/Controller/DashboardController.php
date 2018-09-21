<?php

namespace App\Controller;

use App\Component\AsteriskMonitor;
use App\Component\Helper;
use App\Entity\QueueResult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function monitoring(AsteriskMonitor $monitor) {

        //$monitor = new AsteriskMonitor($this->getDoctrine());

        $this->getDoctrine()->getRepository(QueueResult::class)->getDataFromAsterisk();

        $data = $monitor->getMonitorData();
        return $this->render('dashboard/monitor.html.twig', [
            'data' => $data
        ]);
    }

    /**
     * @Route("/dashboard/search", name="search")
     */
    public function search() {
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
