<?php

namespace src\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakeRepositoryCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('make:repository')
            ->setDescription('Cria um novo repository.')
            ->addArgument('name', InputArgument::REQUIRED, 'Nome do repository')
            ->addOption('table', null, InputOption::VALUE_REQUIRED, 'Nome da tabela para o repositório')
            ->addOption('full', null, InputOption::VALUE_NONE, 'Verifica se é full');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $full = $input->getOption('full');
        $name = $input->getArgument('name');
        $newName = str_replace('Repository', '', $name);
        $directory = __DIR__ . "/../repositories";
        $filename = "$directory/{$name}.php";
        $optionTable = $input->getOption('table');
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        if (file_exists($filename)) {
            $output->writeln("<error>Repository {$name} already exists</error>");
            return Command::FAILURE;
        }

        if (!$full) {
            $template = <<<PHP
    <?php

    namespace src\\repositories;


    class {$newName}Repository extends Querio
    {
        protected string \$table = '$optionTable';
    }

    PHP;
        } else {
            $template = <<<PHP
            <?php
        
            namespace src\\repositories;
        
        
            class $name extends Querio
            {
                protected string \$table = '$optionTable';
            }
        
            PHP;
        }

        file_put_contents($filename, $template);
        $output->writeln("<info>Repository '$name' created successfully!</info>");

        return Command::SUCCESS;
    }
}
