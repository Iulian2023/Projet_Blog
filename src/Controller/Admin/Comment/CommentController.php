<?php

namespace App\Controller\Admin\Comment;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    #[Route('/admin/comment/liste', name: 'admin.comment.index')]
    public function index(CommentRepository $commentRepository): Response
    {


        return $this->render('pages/admin/comment/index.html.twig', [
            "comments" => $commentRepository->findAll(),
        ]);
    }

    #[Route('/admin/comment/{id}/activate', name: 'admin.comment.activate', methods:'PUT')]
    public function activate(Comment $comment,Request $request, EntityManagerInterface $em): Response
    {
        if ( $this->isCsrfTokenValid("comment_activate_".$comment->getId(), $request->request->get('csrf_token'))) {
            if( $comment->isIsActivated())
            {
            $comment->setIsActivated(false);
            $this->addFlash("success", "Le commentaire a été descativé");
        }
        else
        {
            $this->addFlash("success", "Le commentaire a été activé");
            $comment->setIsActivated(true);
        }
        
        $em->persist($comment);
        $em->flush();
        }
        return $this->redirectToRoute('admin.comment.index');
    }

    #[Route('/admin/comment/{id}/delete', name: 'admin.comment.delete', methods:["DELETE"])]
    public function delete(Request $request, comment $comment, EntityManagerInterface $em) : Response
    {
        if ( $this->isCsrfTokenValid('comment_delete_' . $comment->getId(), $request->request->get('csrf_token'))) 
        {
            $em->remove($comment);
            $em->flush();
            
            $this->addFlash("success", "Le commentaire a été supprimmée.");
        }

        return $this->redirectToRoute('admin.comment.index');
    }
}
