<?php

class Youtube
{

	var $defaults = array(
		'title' => "YouTube video player",
		'width' => "450",
		'height' => "283", 
		'src' => '',
		'frameborder' => false,
		'allowfullscreen' => true
	);

	var $Widget;
	
	public function Youtube($widget)
	{
		$this->Widget =& $widget;
	}
	public function code($options = array())
	{
		// If this came from a callback
		if (!empty($options[0])) {
			$options = array('src' => 'http://www.youtube.com/embed/'.$options[1]);
		}
		if (is_string($options)) {
			$options = array('src' => $options);
		}
		$options = array_merge($this->defaults, $options);
		extract($options);
		if (!$src) {
			return false;
		}
		$code = $this->Widget->Html->tag('iframe', false, $options);
		return $this->Widget->Html->tag('div', $code, array('class' => 'mh-multimedia'));
	}
}

?>
