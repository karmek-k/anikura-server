<?php

namespace App\Command;

use App\Service\UserFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UsersCreateCommand extends Command
{
    protected static $defaultName = 'users:create';
    protected static $defaultDescription = 'Creates a user';

    public function __construct(
        private UserFactory $userFactory,
        private EntityManagerInterface $manager
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
            ->addOption('admin', 'a', InputOption::VALUE_NONE, 'Should the user be an admin?');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $isAdmin = $input->getOption('admin');

        if ($isAdmin) {
            $io->note('You have passed the --admin option.');
        }
        
        $username = $input->getArgument('username');
        $password = $io->askHidden('Enter password: ');

        $user = $this->userFactory->createUser($username, $password, $isAdmin);
        $this->manager->persist($user);

        $this->manager->flush();

        $io->success('User ' . $username . ' has been created!');

        return Command::SUCCESS;
    }
}
