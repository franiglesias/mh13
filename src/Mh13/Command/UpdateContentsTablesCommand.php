<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 4/4/17
 * Time: 18:56
 */

namespace Mh13\Command;


use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Schema\Comparator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class UpdateContentsTablesCommand extends Command
{
    protected function configure()
    {
        $this// the name of the command (the part after "bin/console")
        ->setName('mh13:update-contents')// the short description shown while running "php bin/console list"
        ->setDescription(
            'Update contents table.'
        )// the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command updates contents tables to use without Translation')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Preparing DBAL connection.');
        $connection = $this->getConnection();
        $output->writeln('Connection is ready');
        $this->addColumnsToTable(
            'posts',
            [
                'title' => ['type' => 'string', 'options' => ['notnull' => false]],
                'slug' => ['type' => 'string', 'options' => ['notnull' => false]],
                'contents' => ['type' => 'text', 'options' => ['notnull' => false]],
            ]
        );
        $this->listColumns('posts');

    }

    protected function getConnection()
    {
        $config = new Configuration();

        $connectionParams = [
            'dbname' => 'mh14',
            'user' => 'root',
            'password' => 'Fi36101628',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
            'encoding' => 'utf8mb4',
        ];

        return DriverManager::getConnection($connectionParams, $config);
    }

    private function addColumnsToTable($table, $columns)
    {
        $sm = $this->getSchemaManager();
        $current = $sm->createSchema();
        $new = clone $current;
        $theTable = $new->getTable($table);
        foreach ($columns as $name => $type) {
            $theTable->addColumn($name, $type['type'], $type['options']);
        }
        $comparator = new Comparator();
        $schemaDiff = $comparator->compare($current, $new);
        $myPlatform = $this->getConnection()->getDatabasePlatform();
        $queries = $schemaDiff->toSaveSql($myPlatform);
        foreach ($queries as $query) {
            $this->getConnection()->exec($query);
        }
    }

    protected function getSchemaManager()
    {
        $connection = $this->getConnection();

        return $connection->getSchemaManager();
    }

    protected function listColumns($table)
    {
        $sm = $this->getSchemaManager();
        $columns = $sm->listTableColumns($table);
        foreach ($columns as $column) {
            echo $column->getName().': '.$column->getType()."\n";
        }
    }

}
