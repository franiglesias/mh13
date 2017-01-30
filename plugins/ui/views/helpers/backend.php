<?php

/**
* 
*/
class BackendHelper extends AppHelper
{
	
	var $helpers = array('Html');
	var $defaults = array(
		'class' => 'mh-admin-panel',
	);
 	
	public function panel($contents, $options = array())	
	{
		extract($contents);
		$options = array_merge($this->defaults, $options);
		$title = $this->Html->tag('h1', $title, array('class' => 'heading mh-admin-panel-heading'));
		$help = $this->Html->tag('p', $help, array('class' => 'subheading mh-admin-panel-subheading'));
		$header = $this->Html->tag('header', $title.$help, array('class' => 'mh-admin-panel-header'));
		$body = '';
		foreach ($subpanels as $subpanel) {
			$link = $this->Html->link(
				$subpanel['title'],
				$subpanel['url'],
				array('class' => 'mh-button mh-button-backend-panel-button media-object')
				);
			$help = $this->Html->tag('span', $subpanel['help'], array('class' => 'media-body mh-button-backend-panel-help'));
			$buttonBody = $this->Html->tag('span', $link.$help, array('class' => 'media-body mh-button-backend-panel-body'));
			$body .= $this->Html->tag('li', $buttonBody, array('class' => 'media mh-button-backend-panel'));
		}
		$body = $this->Html->tag('ul', $body);
		$body = $this->Html->tag('div', $body, array('class' =>'mh-admin-panel-body'));
		$code = $this->Html->tag('section', $header.$body, array('class' => $options['class'],'id' => 'mh-'.$domain.'-panel'));
		return $code;
	}
	
	public function panel2($panel, $options = array())	
	{
		$help = false;
		extract($panel);
		$options = array_merge($this->defaults, $options);
		$label = $this->Html->tag('h1', $label, array('class' => 'heading mh-admin-panel-heading'));
		if (!empty($help)) {
			$help = $this->Html->tag('p', $help, array('class' => 'subheading mh-admin-panel-subheading'));
		}
		$header = $this->Html->tag('header', $label.$help, array('class' => 'mh-admin-panel-header'));
		$body = '';
		foreach ($subpanels as $subpanel) {
			$body .= $this->Html->tag('li', $this->subpanel($subpanel), array('class' => 'media mh-button-backend-panel'));
		}
		$body = $this->Html->tag('ul', $body);
		$body = $this->Html->tag('div', $body, array('class' =>'mh-admin-panel-body'));
		$code = $this->Html->tag('section', $header.$body, array('class' => $options['class'],'id' => 'mh-'.$domain.'-panel'));
		return $code;
	}
	
	public function button($label, $url = false, $class = false, $help = false, $image = false)
	{
		if (is_array($label)) {
			$button = $label;
			extract($button, EXTR_OVERWRITE);
		}
		$class = 'mh-button mh-subpanel-button'.' '.$class;
		$link = $this->Html->link(
			$label,
			$url,
			array('class' => $class, 'title' => $help)
		);
		return $link;
	}
	
	public function subpanel($subpanel)
	{
		$title = $help = false;
		if (!empty($subpanel['label'])) {
			$title = $this->Html->tag('h1', $subpanel['label'], array('class' => 'heading mh-admin-subpanel-heading'));
		}
		if (!empty($subpanel['help'])) {
			$help = $this->Html->tag('p', $subpanel['help'], array('class' => 'subheading mh-admin-subpanel-subheading'));
		}
		$header = $this->Html->tag('header', $title.$help, array('class' => 'mh-admin-subpanel-header'));
		$buttons = '<ul class="mh-button-backend-subpanel-buttons-list">'.chr(10);
		foreach ($subpanel['buttons'] as $button) {
			$buttons .= $this->Html->tag('li', $this->button($button), array('class' => 'mh-button-backend-subpanel-button')).chr(10);
		}
		$buttons .= '</td>';
		$subpanel = $this->Html->div('mh-button-backend-subpanel', $header.$buttons);
		return $subpanel;
	}
	
	public function menuToPanel($menus,$options = array('label' => 'Panel', 'domain' => 'domain'))
	{
		$contents = $options;
		foreach ($menus as $key => $menu) {
			$menu['Menu']['label'] = $menu['Menu']['help'];
			unset($menu['Menu']['help']);
			$element = $menu['Menu'];
			if (!isset($menu['MenuItem'])) {
				continue;
			}
			foreach ($menu['MenuItem'] as $button) {
				$element['buttons'][] = $button['MenuItem'];
			}
			$contents['subpanels'][] = $element;
		}
		return $contents;
		
	}

/**
 * Simple Helper to create a title for edit views
 *
 * @param string $data 
 * @param string $model 
 * @param string $domain 
 * @param string $title 
 * @return void
 * @author Fran Iglesias
 */	
	public function editHeading($data, $model, $domain, $title)
	{
		if (empty($title)) {
			return sprintf(__('Create %s', true), __d($domain, $model, true));
		} 
		return sprintf(__('Modify %s \'%s\'', true), __d($domain, $model, true),$title);
	}
	
}

?>
