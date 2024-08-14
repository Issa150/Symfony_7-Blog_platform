<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Entity\ContentType;
use App\Repository\PostsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PostsRepository $postsRepository): Response
    {
        $recentPosts = $postsRepository->findBy([], ['createdAt' => 'DESC'], 5);
        $postsTutorials = $postsRepository->findTutorials();
        $postsLists = $postsRepository->findLists();

        return $this->render('pages/home.html.twig', [
            'recentPosts' => $recentPosts,
            'postsTutorials' => $postsTutorials,
            'postsLists' => $postsLists,
        ]);
    }

    #[Route('/feeds-{feeds}', name: 'app_feeds', requirements: ['feeds' => '[a-z]+'])]
    public function feeds(EntityManagerInterface $em, $feeds): Response
    {
        if ($feeds === 'all') {
            $postFeeds = $em->getRepository(Posts::class)->findBy([], ['createdAt' => 'DESC']);
        } else {
            $contentType = $em->getRepository(ContentType::class)->findOneBy(['title' => $feeds]);
            if ($contentType) {
                $postFeeds = $em->getRepository(Posts::class)->findBy(['contentTypeId' => $contentType]);
            } else {
                $postFeeds = [];
            }
        }

        return $this->render('pages/feeds.html.twig', [
            'postFeeds' => $postFeeds,
            'feeds' => $feeds,
        ]);
    }


    #[Route('/post-{id}', name: 'app_post', requirements: ['id' => '\d+'])]
    public function post(EntityManagerInterface $em, $id): Response
    {
        $post = $em->getRepository(Posts::class)->find($id);

        return $this->render('pages/post.html.twig', [
            'post' => $post,
        ]);
    }






    #[Route('/posts', name: 'app_posts')]
    public function posts(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
