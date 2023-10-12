<?php

namespace App\Controller\Visitor\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    #[Route('/', name: 'visitor.welcome.index')]
    public function index(): Response
    {
        return $this->render('pages/visitor/welcome/index.html.twig');
    }
}
