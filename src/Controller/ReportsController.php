<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReportsController
 * @package App\Controller
 */
class ReportsController extends AbstractController
{
    /**
     * @Route("/", name="reports_list")
     */
    public function index()
    {
        return $this->render('reports/index.html.twig', [
            'controller_name' => 'ReportsController',
        ]);
    }
}
