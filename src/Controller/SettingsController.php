<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UserFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SettingsController extends AbstractController
{
    #[Route('/settings', name: 'settings')]
    public function index(): Response
    {
        return $this->render('settings/index.html.twig', [
            'controller_name' => 'SettingsController',
        ]);
    }

    #[Route('/settings/create-user', name: 'settings_create_user')]
    public function createUser(Request $request, UserFactory $userFactory): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $username = $user->getUsername();
            $password = $user->getPassword();

            $newUser = $userFactory->createUser(
                $username,
                $password,
                admin: false
            );

            $manager = $this->getDoctrine()->getManager();

            $manager->persist($newUser);
            $manager->flush();

            $this->addFlash('success', 'User successfully created!');

            return $this->redirectToRoute('settings');
        }

        return $this->render('settings/create_user.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
