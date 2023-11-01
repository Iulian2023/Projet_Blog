<?php

namespace App\Controller\User\Home;

use App\Form\EditProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EditProfilePasswordFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HomeController extends AbstractController
{
    #[Route('/profile/home', name: 'user.home.index')]
    public function index() : Response
    {
        return $this->render('pages/user/home/index.html.twig');
    }

    #[Route('/profile/edit', name: 'user.profile.edit', methods:['GET', 'PUT'])]
    public function edit(Request $request, EntityManagerInterface $em) : Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileFormType::class, $user, [
            "method" => "PUT"
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre profile a été modifier');
            return $this->redirectToRoute("user.home.index");
        }

        return $this->render('pages/user/profile/edit.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/profile/edit_password', name: 'user.profile.edit_password', methods:['GET', 'PUT'])]
    public function edit_password(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher) : Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfilePasswordFormType::class, null, [
            "method" => "PUT"
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->all();
            $password = $data['edit_profile_password_form']['password']['first'];

            $passwordHashed = $hasher->hashPassword($user, $password);
            $user->setPassword($passwordHashed);
            
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre mot de passe a été modifié');
            return $this->redirectToRoute('user.home.index');
        }

        return $this->render("pages/user/profile/edit_password.html.twig", [
            "form" => $form
        ]);
    }

    #[Route('/profile/delete', name: 'user.profile.delete', methods:['DELETE'])]
    public function delete(Request $request, EntityManagerInterface $em) : Response
    {
        $user = $this->getUser();

        $posts = $user->getPosts();

        foreach ($posts as $post) {
            $post->setUser(null);
        }

        if ($this->isCsrfTokenValid('user_profile_delete', $request->request->get('csrf_token'))) 
        {
            $em->remove($user);
            $em->flush();
            
            $this->container->get('security.token_storage')->setToken(null);

            $this->addFlash("success", "Votre compte a été bien suprimmer");
        }
        return $this->redirectToRoute("visitor.authentication.authenticate");
    }
}
