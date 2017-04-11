<?php

namespace Mh13\shared\web\menus;

class MenuItem
{
    private $label;
    private $url;
    private $icon;
    private $class;
    private $access;
    private $help;

    /**
     * MenuItem constructor.
     *
     * @param $label
     * @param $url
     * @param $icon
     * @param $class
     * @param $access
     * @param $help
     */
    public function __construct($label, $url, $icon, $class, $access, $help)
    {
        $this->label = $label;
        $this->url = $url;
        $this->icon = $icon;
        $this->class = $class;
        $this->access = $access;
        $this->help = $help;
    }

    public static function fromConfiguration(array $data)
    {
        $data = self::ensureAllPropertiesAreDefined($data);
        $menuItem = new static(
            $data['label'], $data['url'], $data['icon'], $data['class'], $data['access'], $data['help']
        );

        return $menuItem;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public static function ensureAllPropertiesAreDefined(array $data): array
    {
        $defaults = [
            'label' => '',
            'url' => '',
            'access' => '0',
            'help' => '',
            'icon' => '',
            'class' => '',
        ];
        $data = array_merge($defaults, $data);

        return $data;
    }

    public function getLabel()
    {
        return $this->label;
    }


}
