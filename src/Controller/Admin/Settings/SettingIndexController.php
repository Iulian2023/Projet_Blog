<?php

namespace App\Controller\Admin\Settings;

use App\Entity\SettingsIndex;
use App\Form\SettingsIndexFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SettingIndexController extends AbstractController
{
    #[Route('/admin/setting/setting-index/{id}/edit', name: 'admin.setting_index.edit', methods:['GET', 'PUT'])]
    public function edit(SettingsIndex $settingsIndex, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(SettingsIndexFormType::class, $settingsIndex, [
            "method" => "PUT"
           ]);

           $form->handleRequest($request);

           if ($form->isSubmitted() && $form->isValid()) 
           {
            $em->persist($settingsIndex);
            $em->flush();
    
            $this->addFlash("success", "La catégorie a été modifier avec succès");
            return $this->redirectToRoute("admin.dashboard.index");
           }

        return $this->render('pages/admin/settings/settingIndex.html.twig', [
            "form" => $form->createView(),
           ]);
    }
}
