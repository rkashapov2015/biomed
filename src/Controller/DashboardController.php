<?php

namespace App\Controller;

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
    public function monitoring() {
        return $this->render('dashboard/index.html.twig', []);
    }

    /**
     * @Route("/dashboard/search", name="search")
     */
    public function search() {
        return $this->render('dashboard/index.html.twig', []);
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
