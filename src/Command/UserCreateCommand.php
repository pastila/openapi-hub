<?php

namespace App\Command;

use App\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserCreateCommand extends Command
{
  protected static $defaultName = 'app:user:create';
  protected static $defaultDescription = 'Create new admin user';

  private $entityManager;
  private $userPasswordEncoder;

  public function __construct (EntityManagerInterface  $entityManager,
                               UserPasswordEncoderInterface $userPasswordEncoder,
                               string $name = null)
  {
    $this->entityManager = $entityManager;
    $this->userPasswordEncoder = $userPasswordEncoder;
    parent::__construct($name);
  }


  protected function configure (): void
  {
    $this
      ->setDescription(self::$defaultDescription)
      ->addArgument('email', InputArgument::OPTIONAL, 'Email')
      ->addArgument('password', InputArgument::OPTIONAL, 'Password')
      ->addArgument('role', InputArgument::OPTIONAL, 'Role');
  }

  protected function execute (InputInterface $input, OutputInterface $output): int
  {
    $io = new SymfonyStyle($input, $output);
    $email = $input->getArgument('email');
    $password = $input->getArgument('password');
    $role = $input->getArgument('role');

    if (!$email)
    {
      $email = $io->ask('email');
    }

    if (!$password)
    {
      $password = $io->ask('password');
    }

    if (!$role)
    {
      $role = $io->ask('role');
    }

    $user = new User();
    $user->setEmail($email);
    $user->setPassword($this->userPasswordEncoder->encodePassword($user, $password));
    $user->setRoles([$role]);
    $this->entityManager->persist($user);
    $this->entityManager->flush();

    return Command::SUCCESS;
  }
}
