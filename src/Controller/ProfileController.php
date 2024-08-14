<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile-{tab}', name: 'app_profile_tab', methods: ['GET', 'POST'])]
    public function tab(Request $request, string $tab = 'user_info', UsersRepository $usersRepository, TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager): Response
    {
        $id = $request->query->get('id');
        if ($id) {
            $user = $usersRepository->find($id);
        } else {
            $user = $tokenStorage->getToken()->getUser();
        }

        $currentUser = $tokenStorage->getToken()->getUser();
        $canEdit = $currentUser === $user;

        switch ($tab) {
            case 'user_info':

                return $this->render('profile/index.html.twig', [
                    'user' => $user,
                    'canEdit' => $canEdit,
                    'tab' => $tab,
                ]);

            case 'account_setting':
                // Handle account setting tab
                // You can add your logic here to handle account setting
                return $this->render('profile/index.html.twig', [
                    'user' => $user,
                    'canEdit' => $canEdit,
                    'tab' => $tab,
                ]);

            case 'edit':
                if (!$this->isGranted('ROLE_USER') || $user !== $tokenStorage->getToken()->getUser()) {
                    throw new AccessDeniedException();
                }

                $form = $this->createForm(UsersType::class, $user);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $entityManager->flush();
                    return $this->redirectToRoute('app_profile_tab', ['tab' => 'edit'], Response::HTTP_SEE_OTHER);
                }

                return $this->render('profile/index.html.twig', [
                    'user' => $user,
                    'tab' => $tab,
                    'form' => $form->createView(),
                ]);

            default:
                // If the tab is not found, show the user_info tab by default
                return $this->redirectToRoute('app_profile_tab', ['tab' => 'user_info']);
        }
    }

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