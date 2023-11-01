<?php

namespace App\Controller\Admin\Contact;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/admin/contact/list', name: 'admin.contact.index')]
    public function index(ContactRepository $contactRepository): Response
    {
        return $this->render('pages/admin/contact/index.html.twig', [
            'contacts'=> $contactRepository->findAll(),
        ]);
    }

    #[Route('/admin/contact/{id}/delete', name: 'admin.contact.delete', methods:['DELETE'])]
    public function delete(Contact $contact, Request $request, EntityManagerInterface $em) : Response
    {
        if ($this->isCsrfTokenValid("delete-contact-".$contact->getId(), $request->request->get('csrf_token'))) 
        {
            $em->remove($contact);
            $em->flush();

            $this->addFlash('success', 'Le contact a été supprimé');
        }

        return $this->redirectToRoute('admin.contact.index');
    }
}
