<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\User;
use App\Form\MediaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('dashboard/index.html.twig', [
            'userContent' => $user->getMedia(),
        ]);
    }

    #[Route('/dashboard/upload', name: 'dashboard_upload')]
    public function upload(Request $request): Response
    {
        // /** @var User $user */
        // $user = $this->getUser();
        $file = new Media();

        $form = $this->createForm(MediaType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($file);
            $this->addFlash('info', 'The file has been successfully uploaded');
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('dashboard/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
