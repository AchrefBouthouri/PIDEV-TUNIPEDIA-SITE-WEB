<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="app_admin_dashboard")
     */
    public function index(): Response
    {
        return $this->render('admin_dashboard/index.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);
    }

        /**
     * @Route("/allusers", name="allusers")
     */
    public function AllUsers(): Response
    {
        return $this->render('admin_dashboard/AllUsers.html.twig');
    }
}
