<?php

namespace App\Controller;

use App\Entity\Media;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Handler\DownloadHandler;

class MediaController extends AbstractController
{
    #[Route('/media/{id}', name: 'media')]
    public function index(Media $media, DownloadHandler $downloadHandler): Response
    {
        $user = $this->getUser();

        if (!$media->getOwner() !== $user) {
            $this->createAccessDeniedException();
        }

        return $downloadHandler->downloadObject(
            $media,
            field: 'file',
        );
    }

    #[Route('/media/player/{id}', name: 'media_player')]
    public function player(Media $media): Response
    {
        $user = $this->getUser();

        if (!$media->getOwner() !== $user) {
            $this->createAccessDeniedException();
        }

        return $this->render('media/player.html.twig', [
            'media' => $media,
        ]);
    }
}
