<?php

namespace App\Controller;

use App\Entity\Media;
use App\Service\AccessChecker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Handler\DownloadHandler;

class MediaController extends AbstractController
{
    #[Route('/media/{id}', name: 'media')]
    public function index(Media $media, DownloadHandler $downloadHandler, AccessChecker $checker): Response
    {
        $checker->checkOwnership($media);

        return $downloadHandler->downloadObject(
            $media,
            field: 'file',
        );
    }

    #[Route('/media/player/{id}', name: 'media_player')]
    public function player(Media $media, AccessChecker $checker): Response
    {
        $checker->checkOwnership($media);

        return $this->render('media/player.html.twig', [
            'media' => $media,
        ]);
    }
}
