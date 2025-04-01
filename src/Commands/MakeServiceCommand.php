<?php

namespace src\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakeServiceCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('make:service')
            ->setDescription('Cria um novo service.')
            ->addArgument('name', InputArgument::REQUIRED, 'Nome do service')
            ->addOption('full', null, InputOption::VALUE_NONE, 'Executar outros comandos como make:service e make:repository');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $directory = __DIR__ . "/../services";
        $filename = "$directory/{$name}.php";
        $full = $input->getOption('full');
        $newName = str_replace('Service', '', $name);
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        if (file_exists($filename)) {
            $output->writeln("<error>Service {$name} already exists</error>");
            return Command::FAILURE;
        }

        if (!$full) {
            $template = <<<PHP
    <?php

    namespace src\services;

    class $name
    {
        public function index()
        {
            echo "Método index de $name";
        }
    }

    PHP;
        } else {
            $template = <<<PHP
    <?php

    namespace src\services;

    use src\\repositories\\{$newName}Repository;

    class $name
    {
        public function __construct(private {$newName}Repository \${$newName}Repository){}
    }

    PHP;
        }

        file_put_contents($filename, $template);
        $output->writeln("<info>Service '$name' created successfully!</info>");

        return Command::SUCCESS;
    }
}
