<?php

namespace App\Controller\Admin\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashBoardController extends AbstractController
{
    #[Route('/admin/home/dashboard', name: 'admin.dashboard.index')]
    public function index(): Response
    {
        return $this->render('pages/admin/home/dashboard/index.html.twig');
    }
}
