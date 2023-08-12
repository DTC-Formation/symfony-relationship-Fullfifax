<?php

namespace App\Command;

use App\Manager\StudentManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'formmulera:create:user',
    description: 'User creation',
)]
class CreateUserCommand extends Command
{

    private $studentManager;

    public function __construct(StudentManager $studentManager)
    {
        parent::__construct();
        $this->studentManager = $studentManager;
    }

    protected function configure(): void
    {
        $this
            ->addOption('superadmin', null, InputOption::VALUE_OPTIONAL)
            ->addOption('name', null, InputOption::VALUE_OPTIONAL)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        
        $style = new SymfonyStyle($input, $output);
        
        $helper = $this->getHelper('question');

        $adminName = $style->ask("What's admin's name");
        
        $isSuperAdmin = $input->getOption('superadmin');

        if($adminName) {
            $style->success('Superadmin is in da place ' . $isSuperAdmin);

            $this->studentManager->generateSuperAdmin($style, $adminName);
            
            return Command::SUCCESS;
        }

        $style->warning('Admin name required');

        return Command::FAILURE;
    }
}
