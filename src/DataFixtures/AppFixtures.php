<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Service\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordEncoderInterface $encoder,
        private UserFactory $userFactory
    ) {}

    public function load(ObjectManager $manager)
    {
        $manager->persist(
            $this->userFactory->createUser(
                'admin',
                'admin',
                admin: true
            )
        );

        $manager->persist(
            $this->userFactory->createUser(
                'user',
                'user',
                admin: false
            )
        );

        $manager->flush();
    }
}
