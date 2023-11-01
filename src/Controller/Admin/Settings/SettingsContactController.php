<?php

namespace App\Controller\Admin\Settings;

use App\Entity\SettingsContact;
use App\Form\SettingsContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SettingsContactController extends AbstractController
{
    #[Route('/settings/{id}/contact/', name: 'admin.setting_contact.edit')]
    public function edit(SettingsContact $settingsContact, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(SettingsContactFormType::class, $settingsContact, [
            "method" => "PUT"
           ]);

           $form->handleRequest($request);

           if ($form->isSubmitted() && $form->isValid()) 
           {
            $em->persist($settingsContact);
            $em->flush();
    
            $this->addFlash("success", "Les contacts ont été modifier avec succès");
            return $this->redirectToRoute("admin.dashboard.index");
           }

        return $this->render('pages/admin/settings/settingsContact.html.twig', [
            "form" => $form->createView(),
           ]);
    }
}
