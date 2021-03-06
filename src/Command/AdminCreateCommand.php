<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminCreateCommand extends Command
{
    protected static $defaultName = 'app:adminCreate';

    private $entityManager;
    private $encoder;
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $this->entityManager= $entityManager;
        $this->encoder = $encoder;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('email', InputArgument::REQUIRED, 'Email description')
            ->addArgument('password', InputArgument::REQUIRED, 'Password description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        if (null === $email || null === $password){
            $io->error('Ta pas rentré d\'email et/ou de password salaud');
            return;
        }
        $io->note(sprintf('Create a User for email: %s', $email));
        $user = new User();
        $user->setEmail($email);

        $passwordEncoded = $this->encoder->encodePassword($user, $password);
        $user->setPassword($passwordEncoded);
        $user->setRoles(['ROLE_ADMIN','ROLE_USER']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $io->success(sprintf('You\'ve created an Admin-user with email: %s and password %s', $email,$password));
    }
}
