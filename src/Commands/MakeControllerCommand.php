<?php

namespace src\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;

class MakeControllerCommand extends Command
{

    protected function configure()
    {
        $this
            ->setName('make:controller')
            ->setDescription('Cria um novo controller.')
            ->addArgument('name', InputArgument::REQUIRED, 'Nome do controller')
            ->addOption('full', null, InputOption::VALUE_NONE, 'Executar outros comandos como make:service e make:repository');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {


        $name = $input->getArgument('name');
        $full = $input->getOption('full');
        $directory = __DIR__ . "/../controllers";
        $filename = "$directory/{$name}.php";

        // Verifica se a pasta 'controllers' existe, se não, cria
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        if (file_exists($filename)) {
            $output->writeln("<error>Controller {$name} already exists</error>");
            return Command::FAILURE;
        }

        $newName = str_replace('Controller', '', $name);

        if (!$full) {
            $template = <<<PHP
    <?php

    namespace src\controllers;

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

    namespace src\controllers;

    use src\services\\{$newName}Service;

    class $name
    {
        public function __construct(private {$newName}Service \${$newName}Service) { }

        public function index()
        {
            echo "Método index de $name";
        }
    }

    PHP;
        }

        file_put_contents($filename, $template);
        $output->writeln("<info>Controller '$name' created successfully!</info>");



        // Se a opção --full for passada, executa os outros comandos
        if ($full) {
            // Criação do nome para o service e repository
            $serviceName = $newName . 'Service';
            $repositoryName = $newName . 'Repository';

            // Nome da tabela no formato plural
            $tableName = $this->pluralize($newName);

            // Executa o comando make:service
            $this->runCommand('make:service', $serviceName, $output, ['--full' => true]);

            // Executa o comando make:repository com a opção --table
            $this->runCommand('make:repository', $repositoryName, $output, ['--full' => true, '--table' => strtolower($tableName)]);
        }

        return Command::SUCCESS;
    }

    private function runCommand($commandName, $name, OutputInterface $output, $options = [])
    {
        // Obtém a aplicação para executar o comando
        $application = $this->getApplication();
        $command = $application->find($commandName);

        // Cria o ArrayInput com o nome e as opções
        $inputArgs = ['command' => $commandName, 'name' => $name];
        $inputArgs = array_merge($inputArgs, $options);

        // Cria o ArrayInput com os parâmetros passados
        $input = new ArrayInput($inputArgs);

        // Executa o comando
        $command->run($input, $output);
    }

    private function pluralize($word)
    {
        // Método simples para pluralizar a palavra
        // Isso pode ser mais complexo dependendo do idioma
        return $word . 's';  // Plural básico, para exemplo
    }
}
