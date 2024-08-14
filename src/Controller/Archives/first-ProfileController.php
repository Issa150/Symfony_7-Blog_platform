<?php
/*
namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/profile')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'app_profile_index', methods: ['GET'])]
    public function index(Request $request, UsersRepository $usersRepository, TokenStorageInterface $tokenStorage,EntityManagerInterface $entityManager): Response
    {
        $id = $request->query->get('id');
        if ($id) {
            $user = $usersRepository->find($id);
        } else {
            $user = $tokenStorage->getToken()->getUser();
        }

        $currentUser = $tokenStorage->getToken()->getUser();
        $canEdit = $currentUser === $user;
        //---

        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'canEdit' => $canEdit,
            'form' => $form->createView(),
        ]);
    }

    // #[Route('/edit', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    // #[Security("is_granted('ROLE_USER') and user === tokenStorage.getToken().getUser()")]
    // public function edit(Request $request, TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager): Response
    // {
    /*
    #[Route('/edit', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager): Response
    {
        $user = $tokenStorage->getToken()->getUser();
        if (!$this->isGranted('ROLE_USER') || $user !== $tokenStorage->getToken()->getUser()) {
            throw new AccessDeniedException();
        }
        // $user = $tokenStorage->getToken()->getUser();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profile/partials/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
        */

    // #[Route('/delete', name: 'app_profile_delete', methods: ['POST'])]
    // public function delete(Request $request, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage): Response
    // {
    //     $user = $tokenStorage->getToken()->getUser();
    //     if ($this->isCsrfTokenValid('delete'.$user->id, $request->getPayload()->getString('_token'))) {
    //         $entityManager->remove($user);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_logout', [], Response::HTTP_SEE_OTHER);
    // }
    /*
    #[Route('/delete', name: 'app_profile_delete', methods: ['POST'])]
    public function delete(Request $request, TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager): Response
    {
        $user = $tokenStorage->getToken()->getUser();
        $currentUserIdentifier = $tokenStorage->getToken()->getUserIdentifier();
        if ($this->isCsrfTokenValid('delete' . $currentUserIdentifier, $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_logout', [], Response::HTTP_SEE_OTHER);
    }
}
    */
