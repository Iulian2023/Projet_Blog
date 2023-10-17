<?php

namespace App\Controller\Admin\Country;

use App\Entity\Countries;
use App\Form\CountriesFormType;
use App\Repository\CountriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Country;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CountryController extends AbstractController
{
    #[Route('/admin/country/list', name: 'admin.country.list')]
    public function index(CountriesRepository $countriesRepository): Response
    {
        $countries = $countriesRepository->findby([], ['createdAt' => 'DESC']);
        
        return $this->render('pages/admin/country/index.html.twig', [
            "countries" => $countries,
        ]);
    }

    #[Route('/admin/country/create', name: 'admin.country.create', methods:['GET', 'POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $em
    ): Response
    {
        $country = new Countries();

        $form = $this->createForm(CountriesFormType::class, $country);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($country);
            $em->flush();

            $this->addFlash("success", "La pays a été ajouter");

            return $this->redirectToRoute("admin.country.list");
        
        }


        return $this->render('pages/admin/country/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/country/{id}/edit', name: 'admin.country.edit', methods:['GET', 'PUT'])]
    public function edit(
        Request $request,
        EntityManagerInterface $em,
        Countries $countries
    ) : Response
    {
        $form = $this->createForm(CountriesFormType::class, $countries, [
            "method" => 'PUT',
        ]);

        $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($countries);
            $em->flush();

            $this->addFlash("success", "La pays a été modifié");

            return $this->redirectToRoute('admin.country.list');
       }

       return $this->render("pages/admin/country/edit.html.twig", [
        "form"  => $form->createView(),
        "country"  => $countries
    ]);
    }

    #[Route('/admin/country/{id}/delete', name: 'admin.country.delete', methods: ['DELETE'])]
    public function delete(
        Countries $countries,
        Request $request, 
        EntityManagerInterface $em,
    ) : Response
    {

        if ( $this->isCsrfTokenValid('country_delete_' . $countries->getId(), $request->request->get('csrf_token'))) 
        {
            $em->remove($countries);
            $em->flush();
            
            $this->addFlash("success", "La pays a été supprimmée.");
        }

        return $this->redirectToRoute('admin.country.list');

    }
}
