<?php

namespace App\Controller\Admin\Category;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/admin/category/list', name: 'admin.category.index', methods: ['GET', 'POST'])]
    public function index(CategoryRepository $categoryRepository, Request $request, EntityManagerInterface $em): Response
    {
        $categories = $categoryRepository->findAll();
        $category = new Category();

        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em->persist($category);
            $em->flush();

            $this->addFlash("success", "La catégorie a été ajoutée avec succès");
            return $this->redirectToRoute('admin.category.index');
        }

        return $this->render('pages/admin/category/index.html.twig', [
            "form" => $form->createView(),
            "categories" => $categories
        ]);
    }

    #[Route('/admin/category/{id}/edit', name: 'admin.category.edit', methods: ['GET', 'PUT'])]
    public function edit(Category $category, Request $request, EntityManagerInterface $em) : Response
    {
        
       $form = $this->createForm(CategoryFormType::class, $category, [
        "method" => "PUT"
       ]);

       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) 
       {
        $em->persist($category);
        $em->flush();

        $this->addFlash("success", "La catégorie a été modifier avec succès");
        return $this->redirectToRoute("admin.category.index");
       }

       return $this->render("pages/admin/category/edit.html.twig", [
        "form" => $form->createView(),
       ]);
    }

    #[Route('/admin/category/{id}/delete', name: 'admin.category.delete', methods: ['DELETE'])]
    public function delete(Category $category, Request $request, EntityManagerInterface $em): Response
    {
        if ( $this->isCsrfTokenValid('delete_category_' . $category->getId(), $request->request->get('csrf_token'))) 
        {
            $em->remove($category);
            $em->flush();
            
            $this->addFlash("success", "La catégorie ainsi que tous les articles ont été supprimmée.");
        }

        return $this->redirectToRoute('admin.category.index');
    }

}
