<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFactory
{
    public function __construct(
        private UserPasswordEncoderInterface $encoder
    ) {}

    /**
     * Creates a `User` object (without persisting it)
     */
    public function createUser(
        string $username,
        string $password,
        bool $admin = false
    ) {
        $user = new User();

        $user->setUsername($username);
        $user->setPassword(
            $this->encoder->encodePassword($user, $password)
        );

        if ($admin) {
            $user->setRoles(['ROLE_ADMIN']);
        }

        return $user;
    }
}