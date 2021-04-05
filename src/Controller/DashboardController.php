<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\User;
use App\Form\MediaType;
use App\Service\AccessChecker;
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
        $file = new Media();

        $form = $this->createForm(MediaType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $this->getUser();
            $file->setOwner($user);

            $mg = $this->getDoctrine()->getManager();

            $mg->persist($file);
            $mg->flush();

            $this->addFlash('info', 'The file has been successfully uploaded');
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('dashboard/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/dashboard/media/{id}', name: 'dashboard_media')]
    public function media(Media $media, AccessChecker $checker)
    {
        $checker->checkOwnership($media);

        $playerEnabled = in_array(
            $media->getMimeType(),
            ['video/mp4', 'video/webm']
        );

        return $this->render('dashboard/media.html.twig', [
            'player_enabled' => $playerEnabled,
            'media' => $media,
        ]);
    }
}
