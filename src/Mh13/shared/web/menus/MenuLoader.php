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

    public function load(string $menuLabel)
    {
        return $this->loadFromFile($menuLabel);
    }

    private function loadFromFile(string $menuLabel)
    {
        $data = Yaml::parse(file_get_contents($this->file));

        return $data['menus'][$menuLabel];
    }
}
