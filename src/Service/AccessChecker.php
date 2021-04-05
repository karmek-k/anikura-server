<?php

namespace App\Service;

use App\Entity\Media;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class AccessChecker
{
    public function __construct(private Security $security) {}

    /**
     * Checks if the current user owns `$media`.
     * If they don't, an `AccessDeniedException` is thrown.
     */
    public function checkOwnership(Media $media)
    {
        $currentUser = $this->security->getUser();
        $isAdmin = in_array('ROLE_ADMIN', $currentUser->getRoles());

        if ($media->getOwner() !== $currentUser && !$isAdmin) {
            throw new AccessDeniedException();
        }
    }
}