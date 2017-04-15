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

        return array_merge($defaults, $data);
    }

    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return mixed
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * @return mixed
     */
    public function getHelp()
    {
        return $this->help;
    }


}
