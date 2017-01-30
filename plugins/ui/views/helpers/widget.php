<?php
/**
 *  widget helper
 *
 *  Factory to put html code widgets in views
 *
 *  Usage $this->Widget->put('theWidget', $options);
 *
 *  Created by  on 2010-12-21.
 *  Copyright (c) 2010 Fran Iglesias. All rights reserved.
 **/

class WidgetHelper extends AppHelper
{
	var $helpers = array('Html');

/**
 * Generates widget code
 *
 * @param string $widget The name of the widget. Must match a widgets/widget.php with class Widget
 * @param array $options Proper options for the widget
 * @return string HTML code
 */
	public function put($widget, $options = array()) {
		$class = Inflector::classify($widget);
		if (!class_exists($class)) {
			$path = 'widgets'.DS.$widget.'.php';
			if (!file_exists($path)) {
				// return false;
			}
			include_once($path);
		}
		$widget = new $class($this);
		$code = $widget->code($options);
		$code = $this->Html->tag('aside', $code, array('class' => 'widget','id' => $class.'-widget'));
		return $code;
	}

}


?>
