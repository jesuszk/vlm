<?php

namespace src\commands;

use src\database\Database;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DbMigrate extends Command
{
    protected function configure()
    {
        $this
            ->setName('db:migrate')
            ->setDescription('Executa as migrações do banco de dados.')
            ->addArgument('file', InputArgument::REQUIRED, 'Nome do arquivo de migração')
            ->addOption('path', null, InputOption::VALUE_OPTIONAL, 'Se o caminho do arquivo de migração é diferente do padrão');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = $input->getArgument('file');
        $path = $input->getOption('path');
        $directory = __DIR__ . "/../database/migrations";

        $filename = $path ? "$directory/{$path}/{$file}.sql" : "$directory/{$file}.sql";
        
        if (!file_exists($filename)) {
            $output->writeln("<error>Arquivo de migração não encontrado</error>");
            return Command::FAILURE;
        }

        $config_text = file_get_contents(__DIR__ . '/../../.env');
        preg_match_all('/(DB_[A-Z_]+)="([^"]*)"/', $config_text, $matches);
        $db_config = array_combine($matches[1], $matches[2]);
        $db = (new Database);
        $db->config($db_config['DB_TYPE'], $db_config['DB_HOST'], $db_config['DB_NAME'], $db_config['DB_USER'], $db_config['DB_PASSWORD']);
        $db = $db->get();
        $queries = array_filter(explode(';', file_get_contents($filename)));
        
        foreach ($queries as $query) {
            $db->exec($query);
        }

        $output->writeln("<info>Executando migração '{$file}.sql'...</info>");
        $output->writeln("<info>Arquivo de migração '{$file}.sql' executado com sucesso 🎉</info>");

        return Command::SUCCESS;
    }
}
