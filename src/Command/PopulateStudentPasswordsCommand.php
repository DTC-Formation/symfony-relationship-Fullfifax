<?php

namespace App\Command;

use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#[AsCommand(
    name: 'formmulera:populate:student:passwords',
    description: 'Populate all student passwords',
)]
class PopulateStudentPasswordsCommand extends Command
{

    private $entityManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }
    
    protected function configure(): void
    {
        return;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $students = $this->entityManager->getRepository(Student::class)->findAll();
        $style = new SymfonyStyle($input, $output);

        foreach ($students as $student) {
            $encodedPassword = $this->passwordEncoder->encodePassword($student, '12345678');
            $student->setPassword($encodedPassword);
            $this->entityManager->persist($student);
        }

        $this->entityManager->flush();

        $style->success('Passwords populated successfully.');

        return Command::SUCCESS;
    }
}
