<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 11/4/17
 * Time: 20:27
 */

namespace Mh13\Command;


use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;


class TransferMenusToYamlFileCommand extends Command
{
    private $connection;

    protected function configure()
    {
        $this->setName('mh13:translate-menus')->setDescription('Translate menus to YAML representacion.')->setHelp(
            'This command translates menu structure to a YAML representation'
        )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $data = $this->getData();
    }

    protected function getData()
    {
        $connection = $this->getConnection();
        $menuSQL = 'select * from menus order by bar_id asc, menus.order asc';
        $menusData = $connection->fetchAll($menuSQL);

        $barsSQL = 'select * from bars';
        $barsData = $connection->fetchAll($barsSQL);

        foreach ($barsData as $bar) {
            $bars[$bar['title']] = [
                'label' => $bar['label'],
            ];
            $menuSQL = 'select title from menus where bar_id = ? order by menus.order asc';
            $data = $connection->fetchAll($menuSQL, [$bar['id']]);
            foreach ($data as $menu) {
                $bars[$bar['title']]['menus'][] = $menu['title'];
            }
        }

        $menus = [];
        foreach ($menusData as $menu) {
            $menus[$menu['title']] = [
                'help' => (string)$menu['help'],
                'icon' => (string)$menu['icon'],
                'label' => (string)$menu['label'],
                'url' => (string)$menu['url'],
                'access' => (string)$menu['access'],
            ];

            $itemsSQL = 'select * from menu_items where menu_id = ? order by menu_items.order asc';
            $items = $connection->fetchAll($itemsSQL, [$menu['id']]);
            foreach ($items as $item) {
                if ($item['label'] == '/') {
                    $entry = 'separator';
                } else {
                    $entry = [
                        'label' => (string)$item['label'],
                        'url' => (string)$item['url'],
                        'access' => (string)$item['access'],
                        'help' => (string)$item['help'],
                        'icon' => (string)$item['icon'],
                        'class' => (string)$item['class'],
                    ];
                }
                $menus[$menu['title']]['items'][] = $entry;
            }
        }
        $config = [
            'bars' => $bars,
            'menus' => $menus,
        ];
        $yaml = Yaml::dump($config, 4, 4);
        file_put_contents(dirname(dirname(dirname(__DIR__))).'/config/menus.yml', $yaml);

    }

    private function getConnection(): Connection
    {
        if ($this->connection) {
            return $this->connection;
        }

        $cfg = Yaml::parse(file_get_contents(dirname(dirname(dirname(__DIR__))).'/config/config.yml'));
        $doctrine = $cfg['doctrine']['dbal'];
        $connectionParams = $doctrine['connections'][$doctrine['default_connection']];

        return DriverManager::getConnection($connectionParams, new Configuration());
    }

}
