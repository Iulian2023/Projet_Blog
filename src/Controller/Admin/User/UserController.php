<?php

namespace App\Controller\Admin\User;

use App\Entity\User;
use App\Form\EditUserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/admin/user/list', name: 'admin.user.index')]
    public function index(UserRepository $userRepository, Request $request, EntityManagerInterface $em): Response
    {

        $users = $userRepository->findAll();

        return $this->render('pages/admin/user/index.html.twig', [
            'users'=> $users,
        ]);
    }

    #[Route('/admin/user/{id}/edit', name: 'admin.user.edit')]
    public function edit(User $user, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EditUserFormType::class, $user, [
            'method' => 'PUT'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "Les rôles de " . $user->getFirstName() . " " . $user->getLastName() . " ont été modifié");
            return $this->redirectToRoute('admin.user.index');
        }

        return $this->render("pages/admin/user/edit.html.twig", [
            "user" => $user,
            "form" => $form->createView(),
        ]);   

    }

    #[Route('/admin/user/{id<\d+>}/delete', name: 'admin.user.delete',methods: ['DELETE'])]
    public function delete(User $user, Request $request, EntityManagerInterface $em) : Response
    {
        if ($this->isCsrfTokenValid('delete_user_' . $user->getId(), $request->request->get('csrf_token'))) 
        {
            $posts = $user->getPosts();
            foreach ($posts as $post) {
                $post->setUser(null);
            }

            $this->container->get('security.token_storage')->setToken(null);

            $em->remove($user);
            $em->flush();

            $this->addFlash('success', $user->getFirstName() . " " . $user->getLastName() . " " . "L'utilisateur a été supprime");
        }

        return $this->redirectToRoute('admin.user.index');
    }
}

    