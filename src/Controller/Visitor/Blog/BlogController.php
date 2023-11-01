<?php

namespace App\Controller\Visitor\Blog;

use App\Entity\Tag;
use App\Entity\Post;
use App\Entity\Comment;
use App\Entity\Category;
use App\Entity\PostLike;
use App\Entity\Countries;
use App\Form\CommentFormType;
use App\Repository\TagRepository;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use App\Repository\PostLikeRepository;
use App\Repository\CountriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\SettingsContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\NotNull;

class BlogController extends AbstractController
{
    #[Route('/visitor/blog/list-posts', name: 'visitor.blog.index')]
    public function index(
        SettingsContactRepository $settingsContactRepository,
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        CountriesRepository $countriesRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response
    {
        $data = $settingsContactRepository->findAll();

        $setting = $data[0];

        $categories     = $categoryRepository->findAll();
        $tags           = $tagRepository->findAll();
        $countries      = $countriesRepository->findAll();
        $postPublished = $postRepository->findBy(['isPublished' => true], ["publishedAt" => "DESC"]);

        $posts = $paginator->paginate(
            $postPublished,
            $request->query->getInt('page', 1), /*le numero de page*/
            5 /* La limites des pages */
        );

        return $this->render('pages/visitor/blog/index.html.twig', [
            "posts"      => $posts,
            "categories" => $categories,
            "tags"       => $tags,
            "countries"  => $countries,
            "setting" => $setting,
            "postsImg" => $postRepository->filterPostByPhoto(),
        ]);
    }

    #[Route('/blog/post/{id}/{slug}', name: 'visitor.blog.post.show', methods: ['GET', 'POST'])]
    public function show(
        SettingsContactRepository $settingsContactRepository, 
        Post $post, 
        PostRepository $postRepository, 
        Request $request, 
        EntityManagerInterface $em): Response
    {
        $data = $settingsContactRepository->findAll();

        $setting = $data[0];

        $postRecent = $postRepository->findBy(['isPublished' => true], ["publishedAt" => "DESC"], 3);

        $comment = new Comment;

        $form = $this->createForm(CommentFormType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setPost($post);
            $comment->setUser($this->getUser());

            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute("visitor.blog.post.show", [
                "id"    => $post->getId(),
                "slug" => $post->getSlug()
            ]);
        }

        return $this->render("pages/visitor/blog/show.html.twig", [
            "post" => $post,
            "postRecent" => $postRecent,
            "form" => $form->createView(),
            "setting" => $setting,
            "postsImg" => $postRepository->filterPostByPhoto(),
        ]);
    }

    #[Route('/blog/posts/filter-by-category/{slug}', name: 'visitor.blog.posts.filter_by_category', methods: ['GET'])]
    public function filter_by_category(
        SettingsContactRepository $settingsContactRepository,
        Category $category, 
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        PostRepository $postRepository,
        PaginatorInterface $paginator,
        CountriesRepository $countriesRepository,
        Request $request
        ) : Response
    {
        $data = $settingsContactRepository->findAll();

        $setting = $data[0];
        $postsPublished = $postRepository->filterPostsByCategory($category->getId());
        $categories = $categoryRepository->findAll();
        $tags = $tagRepository->findAll();
        $countries      = $countriesRepository->findAll();

        $posts = $paginator->paginate(
            $postsPublished, 
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render("pages/visitor/blog/index.html.twig", [
            "categories"    => $categories,
            "tags"          => $tags,
            "countries"     => $countries,
            "setting" => $setting,
            "posts"         => $posts,
            "postsImg" => $postRepository->filterPostByPhoto(),
        ]);
    }

    #[Route('/blog/posts/filter-by-tag/{slug}', name: 'visitor.blog.posts.filter_by_tag', methods: ['GET'])]
    public function filter_by_tag(
        Tag $tag,
        TagRepository $tagRepository,
        CategoryRepository $categoryRepository,
        PostRepository $postRepository,
        PaginatorInterface $paginator,
        CountriesRepository $countriesRepository,
        Request $request,
        SettingsContactRepository $settingsContactRepository
    ) : Response
    {
        $data = $settingsContactRepository->findAll();

        $setting = $data[0];
        $tags = $tagRepository->findAll();
        $categories = $categoryRepository->findAll();
        $postsPublished = $postRepository->filterPostsByTag($tag->getId());
        $countries      = $countriesRepository->findAll();

        $posts = $paginator->paginate(
            $postsPublished, 
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render("pages/visitor/blog/index.html.twig", [
            "tags" =>           $tags,
            "categories" =>     $categories,
            "countries"     => $countries,
            "setting" => $setting,
            "posts" =>          $posts,
            "postsImg" => $postRepository->filterPostByPhoto(),
        ]);
    }

    #[Route('/blog/posts/filter-by-country/{slug}', name: 'visitor.blog.posts.filter_by_country', methods: ['GET'])]
    public function filter_by_country(
        SettingsContactRepository $settingsContactRepository,
        Countries $country,
        CountriesRepository $countriesRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        PostRepository $postRepository,
        PaginatorInterface $paginator,
        Request $request
    ) : Response
    {
        $data = $settingsContactRepository->findAll();

        $setting = $data[0];
        $countries = $countriesRepository->findAll();
        $tags = $tagRepository->findAll();
        $categories = $categoryRepository->findAll();
        $postsPublished = $postRepository->filterPostsByCountries($country->getId());

        $posts = $paginator->paginate(
            $postsPublished, 
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render("pages/visitor/blog/index.html.twig", [
            "countries" =>           $countries,
            "categories" =>          $categories,
            "tags" =>                $tags,
            "setting" => $setting,
            "posts" =>               $posts,
            "postsImg" => $postRepository->filterPostByPhoto(),
        ]);
    }

    #[Route('/blog/post/{id}/{slug}/like', name: 'visitor.blog.post.like', methods: ['GET'])]
    public function like(
        Post $post, 
        PostLikeRepository $postLikeRepository,
        EntityManagerInterface $em,
        PostRepository $postRepository,
        SettingsContactRepository $settingsContactRepository
        ) : Response
    {
        $data = $settingsContactRepository->findAll();

        $setting = $data[0];

        /*
         * Récupérons l'utilisateur censé être connecté
         */
        $user = $this->getUser();

        /*
         * S'il est n'est pas connecté
         */
        if (!$user) 
        {
            // Retournons la réponse au navigateur du client, lui expiquant que l'utilisateur n'est pas connecté
            return $this->json(['message' => "Vous devrez être connecté avant d'aimer cet article."], 403);
        }

        /*
         * Dans le cas contraire 
         * 
         * Vérifions, si l'article a déjà aimé par l'utilisateur connecté,
         */
        if ( $post->isLikedBy($user)) 
        {
            // Récupérons ce like
            $like = $postLikeRepository->findOneBy(['post' => $post, 'user' => $user]);
            // Supprimons-le
            $em->remove($like);
            $em->flush();
            // Retournons la réponse correspondante au navigateur du clent pour qu'il mette à jour les données
            return $this->json([
                'message'       => "Le like a été retiré.",
                'totalLikes'    => $postLikeRepository->count(['post' => $post]),
            ]);
        }

        /*
         * Dans le cas contraire,
         * 
         * Créons le nouveau like
         */
        $postLike = new PostLike();
        $postLike->setUser($user);
        $postLike->setPost($post);
         // Demandons au gestionaire des entitiés de réaliser la requête d'insertion en base.
        $em->persist($postLike);
        $em->flush();
         // Retournons la réponse correspondante au navigateur du client pour qu'il mette à jour les données.
        return $this->json([
            'message' => "Le like a été ajouté.",
            'totalLikes'    => $postLikeRepository->count(['post' => $post]),
        ]);
    }
}
