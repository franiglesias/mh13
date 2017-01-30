<?php

/**
* 
*/
class FiImageColor
{
	const TRANSPARENT = 127;
	const OPAQUE = 1;
	const ALPHA = 16777216;
	const RED = 65536;
	const GREEN = 256;
	const BLUE = 1;
	private $hex;
	private $blue;
	private $red;
	private $green;
	private $alpha;
	private $color;
	
	function __construct($hex, $opacity = 1)
	{
		try {
			$this->hex = $this->validate($hex);
		} catch (Exception $e) {
			throw $e;
		}
		$this->alpha = $this->opacityToAlpha($opacity);
		$this->red = hexdec('0x' . $this->hex{0} . $this->hex{1});
		$this->green = hexdec('0x' . $this->hex{2} . $this->hex{3});
		$this->blue = hexdec('0x' . $this->hex{4} . $this->hex{5});
		$this->color = $this->color();
	}
	
	private function opacityToAlpha($opacity)
	{
		
		return floor(self::TRANSPARENT * (self::OPAQUE - $opacity));
	}
	
	private function validate($hex)
	{
		if ($hex{0} == '#') {
			$hex = substr($hex, 1);
		}
		if (preg_match('/[^0-9a-fA-F]/', $hex)) {
			throw new InvalidArgumentException(sprintf('%s is not a valid color definition.', $hex), 1);
		}
		if (strlen($hex) === 3) {
			$hex = $this->convert3to6($hex);
		}
		if (strlen($hex) !== 6) {
			throw new InvalidArgumentException(sprintf('%s is not a valid color definition.', $hex), 1);
		}
		return $hex;
	}
	
	private function convert3to6($hex)
	{
		return $hex{0}.$hex{0}.$hex{1}.$hex{1}.$hex{2}.$hex{2};
	}
	
	private function color()
	{
		return $this->alpha * self::ALPHA 
					 + $this->red * self::RED 
					 + $this->green * self::GREEN 
					 + $this->blue;
	}
	public function getHex()
	{
		return $this->hex;
	}
	
	public function get()
	{
		return $this->color;
	}
	
	public function blue()
	{
		return $this->blue;
	}
	
	public function red()
	{
		return $this->red;
	}
	
	public function green()
	{
		return $this->green;
	}
	
	public function alpha()
	{
		return $this->alpha;
	}
}


?>