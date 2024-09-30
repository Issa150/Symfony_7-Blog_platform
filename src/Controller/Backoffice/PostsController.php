<?php

namespace App\Controller\Backoffice;

use App\Entity\Posts;
use App\Form\PostsType;
use App\Repository\PostsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// #[Route('/posts')]
class PostsController extends AbstractController
{
    // #[Route('backoffice/posts', name: 'posts_index', methods: ['GET'])]
    // public function index(PostsRepository $postsRepository): Response
    // {
    //     return $this->render('posts/index.html.twig', [
    //         'posts' => $postsRepository->findAll(),
    //     ]);
    // }

    #[Route('backoffice/posts/new', name: 'backoffice_posts_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Posts();
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('backoffice_entity_list', ['entity'=> 'Posts'], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backoffice/index.html.twig', [
            'post' => $post,
            'form' => $form,
            'entities' => ['Categories','ContentType','Posts',],
        ]);
    }

    // #[Route('backoffice/posts/{id}', name: 'backoffice_posts_show', methods: ['GET'])]
    // public function show(Posts $post): Response
    // {
    //     return $this->render('posts/show.html.twig', [
    //         'post' => $post,
    //     ]);
    // }

    #[Route('backoffice/Posts/{id}/edit', name: 'backoffice_posts_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Posts $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            // return $this->redirectToRoute('backoffice_index', [], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('backoffice_entity_list', ['entity'=> 'Posts'], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backoffice/index.html.twig', [
        // return $this->render('backoffice/index.html.twig', [
            'post' => $post,
            'form' => $form,
            'entities' => ['Categories','ContentType','Posts',],
        ]);
    }

    #[Route('backoffice/posts/{id}', name: 'backoffice_posts_delete', methods: ['POST'])]
    public function delete(Request $request, Posts $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        // return $this->redirectToRoute('backoffice_index', [], Response::HTTP_SEE_OTHER);
        return $this->redirectToRoute('backoffice_entity_list', ['entity'=> 'Posts'], Response::HTTP_SEE_OTHER);
    }
}
