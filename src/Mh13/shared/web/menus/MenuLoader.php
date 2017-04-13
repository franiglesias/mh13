<?php

namespace Mh13\shared\web\menus;

use Symfony\Component\Yaml\Yaml;


class MenuLoader
{
    private $file;


    /**
     * MenuLoader constructor.
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function load(string $menuTitle)
    {
        return $this->loadFromFile($menuTitle);
    }

    private function loadFromFile(string $menuTitle)
    {
        $data = Yaml::parse(file_get_contents($this->file));

        return Menu::fromConfiguration($menuTitle, $data['menus'][$menuTitle]);
    }
}
