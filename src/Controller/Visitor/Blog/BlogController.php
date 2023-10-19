<?php

namespace App\Controller\Visitor\Blog;

use App\Entity\Tag;
use App\Entity\Post;
use App\Entity\Category;
use App\Entity\Countries;
use App\Repository\TagRepository;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use App\Repository\CountriesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route('/visitor/blog/list-posts', name: 'visitor.blog.index')]
    public function index(
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        CountriesRepository $countriesRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response
    {
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
        ]);
    }

    #[Route('/blog/post/{id}/{slug}', name: 'visitor.blog.post.show', methods: ['GET', 'POST'])]
    public function show(Post $post, PostRepository $postRepository/* Request $request, EntityManagerInterface $em*/): Response
    {
        $postRecent = $postRepository->findBy(['isPublished' => true], ["publishedAt" => "DESC"], 3);

        // $comment = new Comment;

        // $form = $this->createForm(CommentFormType::class, $comment);

        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $comment->setPost($post);
        //     $comment->setUser($this->getUser());

        //     $em->persist($comment);
        //     $em->flush();

        //     return $this->redirectToRoute("visitor.blog.post.show", [
        //         "id"    => $post->getId(),
        //         "slug" => $post->getSlug()
        //     ]);
        // }

        return $this->render("pages/visitor/blog/show.html.twig", [
            "post" => $post,
            "postRecent" => $postRecent
            // "form" => $form->createView()
        ]);
    }

    #[Route('/blog/posts/filter-by-category/{slug}', name: 'visitor.blog.posts.filter_by_category', methods: ['GET'])]
    public function filter_by_category(
        Category $category, 
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        PostRepository $postRepository,
        PaginatorInterface $paginator,
        CountriesRepository $countriesRepository,
        Request $request
        ) : Response
    {
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
            "posts"         => $posts
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
        Request $request
    ) : Response
    {
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
            "posts" =>          $posts
        ]);
    }

    #[Route('/blog/posts/filter-by-country/{slug}', name: 'visitor.blog.posts.filter_by_country', methods: ['GET'])]
    public function filter_by_country(
        Countries $country,
        CountriesRepository $countriesRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        PostRepository $postRepository,
        PaginatorInterface $paginator,
        Request $request
    ) : Response
    {
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
            "posts" =>               $posts
        ]);
    }
}
