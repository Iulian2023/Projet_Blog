<?php

namespace App\Controller\Admin\Statistics;

use App\Repository\TagRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\CommentRepository;
use App\Repository\ContactRepository;
use App\Repository\CategoryRepository;
use App\Repository\PostLikeRepository;
use App\Repository\CountriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatisticsController extends AbstractController
{
    #[Route('/admin/statistics/', name: 'admin.statistics.index')]
    public function index(
        UserRepository $userRepository,
        CategoryRepository $categoryRepository,
        PostRepository $postRepository,
        CountriesRepository $countriesRepository,
        TagRepository $tagRepository,
        ContactRepository $contactRepository,
        CommentRepository $commentRepository,
        PostLikeRepository $postLikeRepository
    ): Response
    {
        return $this->render('pages/admin/statistics/index.html.twig', [
            "users" => $userRepository->findAll(),
            "categories" => $categoryRepository->findAll(),
            "posts"=> $postRepository->findAll(),
            "tags"=> $tagRepository->findAll(),
            "postLikes"=> $postLikeRepository->findAll(),
            "comments"=> $commentRepository->findAll(),
            "contacts" => $contactRepository->findAll(),
            "countries" => $countriesRepository->findAll(),
        ]);
    }
}
