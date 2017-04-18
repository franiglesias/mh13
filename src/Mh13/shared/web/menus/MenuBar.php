<?php

namespace Mh13\shared\web\menus;

class MenuBar
{
    private $title;
    private $label;
    private $menus;


    public function __construct(string $title, string $label)
    {
        $this->title = $title;
        $this->label = $label;
    }

    public static function fromConfiguration($title, $data)
    {
        $menuBar = new MenuBar($title, $data['label']);

        foreach ($data['menus'] as $menu) {
            $menuBar->addMenu($menu);
        }

        return $menuBar;
    }

    public function addMenu(Menu $menu)
    {
        $this->menus[] = $menu;
    }


    public function getMenus(): array
    {
        return $this->menus;
    }

    public function getLabel()
    {
        return $this->label;
    }


}
