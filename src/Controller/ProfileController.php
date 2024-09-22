<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\PostsRepository;
use App\Repository\UsersRepository;
use App\Form\UserAccountSettingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile-{tab}', name: 'app_profile_tab', methods: ['GET', 'POST'])]
    public function tab(Request $request, string $tab = 'user_posts', UsersRepository $usersRepository, PostsRepository $postsRepository, TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager,UserPasswordHasherInterface $userPasswordHasher): Response
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
            case 'user_posts':
                $posts = $postsRepository->findBy(['userId' => $user->getId()]);
                $postsTutorials = $postsRepository->findUserTutorials(5, $user->getId());
                $postsLists = $postsRepository->findUserLists(5, $user->getId());

                return $this->render('profile/index.html.twig', [
                    'user' => $user,
                    'canEdit' => $canEdit,
                    'tab' => $tab,
                    'postsTutorials' =>$postsTutorials,
                    'postsLists' =>$postsLists,
                ]);

            case 'user_info':

                return $this->render('profile/index.html.twig', [
                    'user' => $user,
                    'canEdit' => $canEdit,
                    'tab' => $tab,
                ]);

            case 'account_setting':
                // // chekcing the conction and also if user is in its own page!
                if (!$this->isGranted('ROLE_USER') || $user !== $tokenStorage->getToken()->getUser()) {
                    throw new AccessDeniedException();
                }
                // Handle account setting tab
                // You can add your logic here to handle account setting
                $form = $this->createForm(UserAccountSettingType::class, $user);
                $form->handleRequest($request);


                



                if ($form->isSubmitted() && $form->isValid()) {
                    $user = $form->getData();
                    // encode the plain password
                    $user->setPassword(
                        $userPasswordHasher->hashPassword(
                            $user,
                            $form->get('password')->getData()
                        )
                    );
                    $entityManager->flush();
                    
                    return $this->redirectToRoute('app_profile_tab', ['tab' => 'user_info']);

                }
                return $this->render('profile/index.html.twig', [
                    'user' => $user,
                    'canEdit' => $canEdit,
                    'tab' => $tab,
                    'form' => $form,
                ]);

            case 'edit':
                // // chekcing the conction and also if user is in its own page!
                if (!$this->isGranted('ROLE_USER') || $user !== $tokenStorage->getToken()->getUser()) {
                    throw new AccessDeniedException();
                }

                $form = $this->createForm(UsersType::class, $user);
                // dd($form);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    // dd($form->getErrors());
                    
                    /** @var UploadedFile $imageCover */
                    /** @var UploadedFile $imageProfile */
                    
                    $imageCover = $form->get('imageCover')->getData();
                    $imageProfile = $form->get('imageProfile')->getData();

                    $uploadDirectory = $this->getParameter('kernel.project_dir') . '/public/assets/imgs/banner';

                    if ($imageCover) {
                        $newFilename = uniqid() . '.' . $imageCover->guessExtension();
                        try {
                            $imageCover->move($uploadDirectory, $newFilename);
                            $user->setImageCover($newFilename);
                        } catch (FileException $e) {
                            // Handle exception if something happens during file upload
                        }
                    }
                    $uploadDirectory = $this->getParameter('kernel.project_dir') . '/public/assets/imgs/profile';
                    if ($imageProfile) {
                        $newFilename = uniqid() . '.' . $imageProfile->guessExtension();
                        try {
                            $imageProfile->move($uploadDirectory, $newFilename);
                            $user->setImageProfile($newFilename);
                        } catch (FileException $e) {
                            // Handle exception if something happens during file upload
                        }
                    }
                    $entityManager->flush();
                    
                    return $this->redirectToRoute('app_profile_tab', ['tab' => 'user_info']);
                }

                return $this->render('profile/index.html.twig', [
                    'user' => $user,
                    'tab' => $tab,
                    'form' => $form->createView(),
                    'imageCover' => $user->getimagecover(),
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