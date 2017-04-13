<?php

namespace Mh13\shared\web\menus;

class Menu
{
    private $help;
    private $icon;
    private $label;
    private $url;
    private $access;
    private $title;
    private $items;

    /**
     * Menu constructor.
     *
     * @param $title
     * @param $label
     * @param $url
     * @param $icon
     * @param $help
     * @param $access
     */
    public function __construct($title, $label, $url, $icon, $help, $access = 0)
    {
        $this->help = $help;
        $this->icon = $icon;
        $this->label = $label;
        $this->url = $url;
        $this->access = $access;
        $this->title = $title;
    }

    public static function fromConfiguration(string $title, array $data)
    {
        $data = self::ensureAllPropertiesAreDefined($data);
        $menu = new static($title, $data['label'], $data['url'], $data['icon'], $data['help'], $data['access']);


        foreach ($data['items'] as $item) {
            if ($item == 'separator') {
                $menu->addItem(MenuItem::fromConfiguration(['label' => '/']));
            }
        }
        $menu->addItem(MenuItem::fromConfiguration($item));

        return $menu;
    }

    private static function ensureAllPropertiesAreDefined($data)
    {
        $defaults = [
            'label' => '',
            'url' => '',
            'access' => '0',
            'help' => '',
            'icon' => '',
        ];

        return array_merge($defaults, $data);
    }

    public function addItem(MenuItem $item)
    {
        $this->items[] = $item;
    }

    public function getLabel()
    {
        return $this->label;
    }


}
