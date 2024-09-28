<?php

namespace App\Controller\Backoffice;

use App\Entity\ContentType;
use App\Form\ContentTypeType;
use App\Repository\ContentTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// #[Route('/content/type')]
class ContentTypeController extends AbstractController
{
    // #[Route('backoffice/content-type/', name: 'app_content_type_index', methods: ['GET'])]
    // public function index(ContentTypeRepository $contentTypeRepository): Response
    // {
    //     return $this->render('content_type/index.html.twig', [
    //         'content_types' => $contentTypeRepository->findAll(),
    //     ]);
    // }

    #[Route('backoffice/content-type/new', name: 'app_content_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contentType = new ContentType();
        $form = $this->createForm(ContentTypeType::class, $contentType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contentType);
            $entityManager->flush();

            return $this->redirectToRoute('app_content_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('content_type/new.html.twig', [
            'content_type' => $contentType,
            'form' => $form,
        ]);
    }

    // #[Route('backoffice/content-type/{id}', name: 'app_content_type_show', methods: ['GET'])]
    // public function show(ContentType $contentType): Response
    // {
    //     return $this->render('content_type/show.html.twig', [
    //         'content_type' => $contentType,
    //     ]);
    // }

    #[Route('backoffice/content-type/{id}/edit', name: 'app_content_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ContentType $contentType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContentTypeType::class, $contentType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_backoffice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('content_type/edit.html.twig', [
            'content_type' => $contentType,
            'form' => $form,
        ]);
    }

    #[Route('backoffice/content-type/{id}', name: 'app_content_type_delete', methods: ['POST'])]
    public function delete(Request $request, ContentType $contentType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contentType->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($contentType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_backoffice_index', [], Response::HTTP_SEE_OTHER);
    }
}
