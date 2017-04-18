<?php

namespace Mh13\shared\web\menus;

use Symfony\Component\Yaml\Yaml;


class MenuBarLoader
{
    /**
     * @var string
     */
    private $file;

    public function __construct(string $file)
    {

        $this->file = $file;
    }

    public function load($title)
    {
        $data = Yaml::parse(file_get_contents($this->file));
        $barDefintion = $data['bars'][$title];
        $bar = new MenuBar($title, $barDefintion['label']);
        foreach ($barDefintion['menus'] as $menuTitle) {
            $menuDef = $data['menus'][$menuTitle];
            $bar->addMenu(Menu::fromConfiguration($menuTitle, $menuDef));
        }

        return $bar;
    }
}
