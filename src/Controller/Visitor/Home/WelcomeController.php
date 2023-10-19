<?php

namespace App\Controller\Visitor\Home;

use App\Entity\Countries;
use App\Repository\PostRepository;
use App\Repository\CountriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;   

class WelcomeController extends AbstractController
{
    #[Route('/', name: 'visitor.welcome.index')]
    public function index(Countries $country, PostRepository $postRepository, CountriesRepository $countriesRepository): Response
    {
        $sql = "SELECT DISTINCT countries.country FROM countries INNER JOIN post_countries on countries.id = post_countries.countries_id LIMIT 3";

        return $this->render('pages/visitor/welcome/index.html.twig', [
            "posts" => $postRepository->findBy(["isPublished" => true], ["publishedAt" => "DESC"], 3),
        ]);
        
    }
}
