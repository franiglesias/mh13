<?php
/**
 * BarHelper.
 *
 * Helper to create a hierarchical menu bar, Foundation based
 *
 * @author Fran Iglesias
 *
 * @version $Id$
 *
 * @copyright Fran Iglesias
 **/
class BarHelper extends AppHelper
{
    /**
     * An array containing the names of helpers this controller uses. The array elements should
     * not contain the "Helper" part of the classname.
     *
     * @var mixed A single name as a string or a list of names as an array
     */
    public $helpers = array('Html', 'Form', 'Menus.Menus', 'Menus.Menu');

    public $searchUrl = array('plugin' => 'contents', 'controller' => 'items', 'action' => 'search');

    public $classes = array(
        'nav' => 'top-bar',
        'section' => 'top-bar-section',
        'dropdown' => 'menu vertical',
        'has-dropdown' => 'dropdown menu',
    );

    public $defaults = array(
        'search' => false,
        'classes' => array(
            'nav' => 'top-bar',
            'section' => 'top-bar-section',
            'dropdown' => 'dropdown',
            'has-dropdown' => 'has-dropdown',
        ),
    );

    public function render($bar, $options = array())
    {
        if (empty($bar)) {
            return false;
        }
        $options = Set::merge($this->defaults, $options);
        $this->classses = $options['classes'];
        $code = $this->Html->tag('ul', $this->buildMenuList($bar), array('class' => 'top-bar-left'));
        if (!empty($options['search'])) {
            $code .= $this->Html->tag('ul', $this->searchForm(), array('class' => 'top-bar-right'));
        }

        return $code;
    }

    protected function buildMenuList($bar)
    {
        $menus = '';
        $this->Menus->bind($bar);
        $this->Menus->attach($this->Menu);
        do {
            $this->Menus->next();
            $menus .= $this->Menu->render();
        } while ($this->Menus->hasNext());

        return $menus;
    }

    public function searchForm()
    {
        return $this->divider().$this->Html->tag('li', $this->buildSearchForm(), array('class' => 'has-form'));
    }

    private function buildSearchField()
    {
        return $this->Html->div(
            'large-8 small-9 columns',
            $this->Form->text('Sindex.term', array('placeholder' => __('Search...', true)))
        );
    }

    private function buildSearchButton()
    {
        return $this->Html->div(
            'large-4 small-3 columns',
            $this->Form->button(__('Search', true), array('class' => 'alert button expand'))
        );
    }

    private function buildSearchForm()
    {
        return $this->startForm().
        $this->Html->div('row collapse', $this->buildSearchField().$this->buildSearchButton()).
        $this->Form->end();
    }

    private function startForm()
    {
        return $this->Form->create(null, array('url' => $this->searchUrl, 'action' => null));
    }

// Item render helpers

    private function divider()
    {
        return $this->Html->tag('li', '', array('class' => 'divider'));
    }
}
