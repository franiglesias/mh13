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
use Symfony\Component\Yaml\Yaml;


class UpdateContentsTablesCommand extends Command
{


    private $connection;

    protected function configure()
    {
        $this->setName('mh13:update-contents')->setDescription('Update contents tables.')->setHelp(
            'This command updates contents tables to use without Translation'
        )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Preparing DBAL connection.');
        $this->connection = $this->getConnection();
        $output->writeln('Connection is ready');
        $this->migrateTable(
            'channels',
            'i18n',
            'Channel',
            [
                'title' => ['type' => 'string', 'options' => ['notnull' => false]],
                'description' => ['type' => 'text', 'options' => ['notnull' => false]],
                'tagline' => ['type' => 'string', 'options' => ['notnull' => false]],
                'slug' => ['type' => 'string', 'options' => ['notnull' => false]],
            ]
        );
        $this->migrateTable(
            'items',
            'item_i18ns',
            'Item',
            [
                'title' => ['type' => 'string', 'options' => ['notnull' => false]],
                'content' => ['type' => 'text', 'options' => ['notnull' => false]],
                'slug' => ['type' => 'string', 'options' => ['notnull' => false]],
            ]
        );
        $this->migrateTable(
            'static_pages',
            'static_i18ns',
            'StaticPage',
            [
                'title' => ['type' => 'string', 'options' => ['notnull' => false]],
                'content' => ['type' => 'text', 'options' => ['notnull' => false]],
                'slug' => ['type' => 'string', 'options' => ['notnull' => false]],
            ]
        );
        $this->migrateTable(
            'sites',
            'i18n',
            'Site',
            [
                'title' => ['type' => 'string', 'options' => ['notnull' => false]],
                'description' => ['type' => 'text', 'options' => ['notnull' => false]],
            ]
        );
    }

    private function getConnection()
    {
        if ($this->connection) {
            return $this->connection;
        }

        $cfg = Yaml::parse(file_get_contents(dirname(getcwd()).'/config/config.yml'));
        $doctrine = $cfg['doctrine']['dbal'];
        $connectionParams = $doctrine['connections'][$doctrine['default_connection']];

        return DriverManager::getConnection($connectionParams, new Configuration());
    }

    private function migrateTable($table, $source, $model, array $fields)
    {
        if ($this->tableExists($table)) {
            $this->addColumnsToTable(
                $table,
                $fields
            );
            $this->listColumns($table);
        } else {
            $output->writeln('Table posts does not exists');
        }

        $this->copyTranslatedFieldsBackToTable($table, $source, $model, array_keys($fields));
    }

    private function tableExists($table)
    {
        $sm = $this->getSchemaManager();

        return $sm->tablesExist([$table]);
    }

    private function getSchemaManager()
    {
        $connection = $this->getConnection();

        return $connection->getSchemaManager();
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

    private function listColumns($table)
    {
        $sm = $this->getSchemaManager();
        $columns = $sm->listTableColumns($table);
        foreach ($columns as $column) {
            echo $column->getName().': '.$column->getType()."\n";
        }
    }

    private function copyTranslatedFieldsBackToTable($table, $intTable, $model, $fields)
    {
        foreach ($fields as $field) {
            $sql = sprintf(
                'update %1$s left join %2$s on %2$s.model = \'%4$s\' and %2$s.foreign_key = %1$s.id set %1$s.%3$s = %2$s.content where %2$s.field = \'%3$s\'',
                $table,
                $intTable,
                $field,
                $model
            );
            $deleteSql = sprintf(
                'delete from %2$s where %2$s.model = \'%4$s\'',
                $table,
                $intTable,
                $field,
                $model
            );
            $this->getConnection()->exec($sql);
//            $this->getConnection()->exec($deleteSql);
        }
    }
}
