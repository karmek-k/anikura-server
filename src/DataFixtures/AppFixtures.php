<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordEncoderInterface $encoder) {}

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('admin');
        $admin->setPassword(
            $this->encoder->encodePassword($admin, 'admin')
        );
        $manager->persist($admin);

        $user = new User();
        $user->setUsername('user');
        $user->setPassword(
            $this->encoder->encodePassword($user, 'user')
        );
        $manager->persist($user);

        $manager->flush();
    }
}
