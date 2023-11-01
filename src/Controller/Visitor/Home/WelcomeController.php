<?php

namespace App\Controller\Visitor\Home;

use App\Repository\PostRepository;
use App\Repository\CountriesRepository;
use App\Repository\SettingsIndexRepository;
use App\Repository\SettingsContactRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;   

class WelcomeController extends AbstractController
{
    #[Route('/', name: 'visitor.welcome.index')]
    public function index(SettingsIndexRepository $settingsIndexRepository ,SettingsContactRepository $settingsContactRepository, CountriesRepository $countriesRepository, PostRepository $postRepository): Response
    {
        $data = $settingsContactRepository->findAll();

        $setting = $data[0];

        return $this->render('pages/visitor/welcome/index.html.twig', [
            "posts" => $postRepository->findBy(["isPublished" => true], ["publishedAt" => "DESC"], 3),
            "countries"  => $countriesRepository->filterCountriesByPosts(),
            "settings"   => $settingsIndexRepository->findAll(),
            "setting" => $setting,
            "postsImg" => $postRepository->filterPostByPhoto(),
        ]);
        
    }
}
