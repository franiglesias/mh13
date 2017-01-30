<?php

App::import('Lib', 'fi_value/abstracts/FiFormatter');

class ParseFormatter extends FiFormatter
{
	var $_defaults = array(
		'youtube' => array(
			'title' => 'YouTube video player',
			'width' => 640,
			'height' => 480,
			'frameborder' => false,
			'allowfullscreen' => '1'
		)
	);
	private $formatted;
	
	public function __construct(FiValue $Value, $format = array())
	{
		if (!is_array($format)) {
			$format = array();
		}
		parent::__construct($Value, $format);
	
	}
	public function format()
	{
		// Look for youtube videos
		$this->formatted = $this->_Value->get();
		$this
			->parseYoutubeStandard()
			->parseYoutubeShort();
		return $this->formatted;
	}

	private function parseYoutubeStandard()
	{
		$this->formatted = preg_replace_callback('/https?:\/\/(?:www)?\.youtube\.com\/watch\?v=([a-zA-Z0-9_\-]*)(?:\&[^\s]+)?/', array($this, 'youtube'), $this->formatted);
		return $this;
	}
	
	private function parseYoutubeShort()
	{
		$this->formatted =  preg_replace_callback('/https?:\/\/youtu\.be\/([a-zA-Z0-9_\-]*)/', array($this, 'youtube'), $this->formatted);
		return $this; 
	}
	
	private function youtube($text)
	{
		$options = array_merge($this->_defaults['youtube'], $this->_format);

		if (is_array($text)) {
			$options['src'] = 'https://www.youtube.com/embed/'.$text[1].'?rel=0';
		}
		return sprintf('<iframe %s></iframe>', $this->buildOptions($options));
	}
	
	
	private function buildOptions($options)
	{
		$attr = '';
		foreach ($options as $option => $value) {
			if ($value === true) {
				$part = $option;
			} elseif ($value === false) {
				$part = sprintf('%s="0"', $option);
			} else {
				$part = sprintf('%s="%s"', $option, $value);
			}
			$attr = sprintf($attr.' %s', $part);
		}
		return $attr;
	}
	

}



?>
