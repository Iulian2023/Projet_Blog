<?php

namespace App\Controller\Visitor\Contact;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/visitor/contact/', name: 'visitor.contact.index')]
    public function index(): Response
    {
        return $this->render('pages/visitor/contact/index.html.twig');
    }
}
